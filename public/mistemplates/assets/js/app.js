/* =========================================================
   FILE: assets/js/app.js  (CLEAN / ORGANIZED)
   ========================================================= */
(() => {
  "use strict";

  /* =========================
     HELPERS
  ========================= */
  const $ = (s, root = document) => root.querySelector(s);
  const $$ = (s, root = document) => Array.from(root.querySelectorAll(s));

  const LS = {
    get(key) {
      try { return localStorage.getItem(key); } catch { return null; }
    },
    set(key, val) {
      try { localStorage.setItem(key, val); } catch {}
    },
    del(key) {
      try { localStorage.removeItem(key); } catch {}
    }
  };

  function isMobile() {
    return window.matchMedia("(max-width: 992px)").matches;
  }

  function on(el, evt, cb, opts) {
    if (!el) return;
    el.addEventListener(evt, cb, opts);
  }

  function clamp(n, min, max) {
    return Math.max(min, Math.min(max, n));
  }

  /* =========================
     STATE KEYS
  ========================= */
  const KEY_COLLAPSED = "admin_sidebar_collapsed";
  const KEY_THEME = "admin_theme_class";
  const KEY_SETTINGS = "admin_settings_v1";
  const KEY_PROFILE = "admin_profile_v1";
  const KEY_NOTE = "admin_note";

  const THEMES = [
    "theme-default",
    "theme-blue",
    "theme-softblue",
    "theme-dark",
    "theme-purple",
    "theme-blueviolet",
  ];

  function setBodyTheme(themeClass) {
    const body = document.body;
    if (!body) return;
    THEMES.forEach(t => body.classList.remove(t));
    body.classList.add(themeClass);
    LS.set(KEY_THEME, themeClass);
  }

  function getSavedTheme() {
    const t = LS.get(KEY_THEME);
    return (t && THEMES.includes(t)) ? t : (document.body?.classList.contains("theme-default") ? "theme-default" : "theme-default");
  }

  /* =========================
     SIDEBAR + SUBMENUS + ACTIVE
  ========================= */
  (function initSidebar() {
    const app = $(".app");
    const sidebar = $("#sidebar");
    const overlay = $("#overlay");
    const btnBurger = $("#btnSidebar");
    const btnCollapse = $("#btnCollapse");

    if (!app || !sidebar) return;

    function openMobileSidebar() {
      if (!overlay) return;
      sidebar.classList.add("open");
      overlay.classList.add("show");
    }

    function closeMobileSidebar() {
      if (!overlay) return;
      sidebar.classList.remove("open");
      overlay.classList.remove("show");
    }

    function toggleMobileSidebar() {
      if (!overlay) return;
      sidebar.classList.toggle("open");
      overlay.classList.toggle("show");
    }

    function setCollapsed(val) {
      app.classList.toggle("is-collapsed", !!val);
      LS.set(KEY_COLLAPSED, val ? "1" : "0");
    }

    function toggleCollapsed() {
      setCollapsed(!app.classList.contains("is-collapsed"));
    }

    // Restore collapsed state (desktop)
    if (LS.get(KEY_COLLAPSED) === "1") app.classList.add("is-collapsed");

    // Burger: mobile drawer, desktop optional collapse
    on(btnBurger, "click", (e) => {
      e.preventDefault();
      if (isMobile()) toggleMobileSidebar();
      else toggleCollapsed();
    });

    // Collapse button: desktop collapse, mobile drawer fallback
    on(btnCollapse, "click", (e) => {
      e.preventDefault();
      if (!isMobile()) toggleCollapsed();
      else toggleMobileSidebar();
    });

    // Overlay click closes mobile sidebar + dropdowns
    on(overlay, "click", () => {
      closeMobileSidebar();
      closeAllDropdowns();
      closeThemePanel();
    });

    // Resize: leaving mobile closes drawer
    on(window, "resize", () => {
      if (!isMobile()) closeMobileSidebar();
    });

    // Submenu toggles
    $$(".nav__toggle", sidebar).forEach((toggle) => {
      on(toggle, "click", () => {
        // If desktop collapsed, don't open submenus
        if (!isMobile() && app.classList.contains("is-collapsed")) return;

        const group = toggle.closest(".nav__group");
        if (!group) return;
        group.classList.toggle("open");
      });
    });

    // Auto-close mobile sidebar when clicking nav links
    $$(".sidebar__nav a", sidebar).forEach((a) => {
      on(a, "click", () => {
        if (isMobile()) closeMobileSidebar();
      });
    });

    // Auto active (subitem or top item)
    const currentPage = (app.dataset.page || "").trim();
    if (currentPage) {
      $$(".nav__subitem.active, .nav__item.active", sidebar).forEach((el) => el.classList.remove("active"));

      const sub = $(`.nav__subitem[data-page="${currentPage}"]`, sidebar);
      if (sub) {
        sub.classList.add("active");
        const group = sub.closest(".nav__group");
        if (group) group.classList.add("open");
      } else {
        const top = $(`.nav__item[data-page="${currentPage}"]`, sidebar);
        if (top) top.classList.add("active");
      }
    }
  })();

  /* =========================
     TOPBAR DROPDOWNS
  ========================= */
  function closeAllDropdowns() {
    $$(".dd.open").forEach((dd) => dd.classList.remove("open"));
    $$(".dd__btn[aria-expanded='true']").forEach((b) => b.setAttribute("aria-expanded", "false"));
  }

  (function initDropdowns() {
    const dds = $$(".dd");
    if (!dds.length) return;

    dds.forEach((dd) => {
      const btn = $(".dd__btn", dd);
      if (!btn) return;

      on(btn, "click", (e) => {
        e.stopPropagation();
        const willOpen = !dd.classList.contains("open");
        closeAllDropdowns();
        if (willOpen) {
          dd.classList.add("open");
          btn.setAttribute("aria-expanded", "true");
        }
      });
    });

    on(document, "click", () => closeAllDropdowns());
    on(document, "keydown", (e) => {
      if (e.key === "Escape") closeAllDropdowns();
    });
  })();

  /* =========================
     THEME PANEL (Topbar palette)
     - #themeBtn opens/closes #themePanel
     - .theme-option[data-theme="..."] applies theme
  ========================= */
  let _themePanelOpen = false;

  function closeThemePanel() {
    const panel = $("#themePanel");
    if (!panel) return;
    panel.style.display = "none";
    _themePanelOpen = false;
  }

  function toggleThemePanel() {
    const panel = $("#themePanel");
    if (!panel) return;
    _themePanelOpen = !_themePanelOpen;
    panel.style.display = _themePanelOpen ? "block" : "none";
  }

  (function initThemePanel() {
    const btn = $("#themeBtn");
    const panel = $("#themePanel");
    if (!btn || !panel) {
      // still apply saved theme even if no panel exists
      setBodyTheme(getSavedTheme());
      return;
    }

    // apply saved theme on load
    setBodyTheme(getSavedTheme());

    on(btn, "click", (e) => {
      e.preventDefault();
      e.stopPropagation();
      toggleThemePanel();
      closeAllDropdowns(); // avoid overlap
    });

    // apply theme buttons
    $$(".theme-option", panel).forEach((b) => {
      on(b, "click", () => {
        const t = (b.getAttribute("data-theme") || "").trim();
        if (!THEMES.includes(t)) return;
        setBodyTheme(t);
        closeThemePanel();
      });
    });

    // click outside closes
    on(document, "click", (e) => {
      if (!_themePanelOpen) return;
      if (panel.contains(e.target) || btn.contains(e.target)) return;
      closeThemePanel();
    });

    on(document, "keydown", (e) => {
      if (e.key === "Escape") closeThemePanel();
    });
  })();

  /* =========================
     DASHBOARD COUNTERS
     - Guard: avoids double-run if page also has inline counter
  ========================= */
  (function initCounters() {
    const els = $$("[data-count]");
    if (!els.length) return;

    els.forEach((el) => {
      if (el.dataset.animated === "1") return;

      const target = parseInt(el.dataset.count, 10);
      if (Number.isNaN(target)) return;

      el.dataset.animated = "1";

      let cur = 0;
      const step = Math.max(1, Math.floor(target / 40));
      const timer = setInterval(() => {
        cur += step;
        if (cur >= target) {
          cur = target;
          clearInterval(timer);
        }
        el.textContent = cur.toLocaleString();
      }, 20);
    });
  })();

  /* =========================
     TABLE PAGER (REUSABLE)
  ========================= */
  function initTablePager({ tableId, searchId, infoId, pagerId, pageSize = 5, extraFilterFn = null }) {
    const table = document.getElementById(tableId);
    const pager = document.getElementById(pagerId);
    if (!table || !pager) return;

    const search = searchId ? document.getElementById(searchId) : null;
    const info = infoId ? document.getElementById(infoId) : null;

    const tbody = table.querySelector("tbody");
    if (!tbody) return;

    const allRows = Array.from(tbody.querySelectorAll("tr"));
    let filteredRows = [...allRows];
    let currentPage = 1;

    const totalPages = () => Math.max(1, Math.ceil(filteredRows.length / pageSize));

    function applyFilter() {
      const q = (search?.value || "").toLowerCase().trim();
      filteredRows = allRows.filter((row) => {
        const matchText = row.innerText.toLowerCase().includes(q);
        const matchExtra = extraFilterFn ? extraFilterFn(row) : true;
        return matchText && matchExtra;
      });
      currentPage = 1;
    }

    function renderRows() {
      allRows.forEach((r) => (r.style.display = "none"));

      const startIdx = (currentPage - 1) * pageSize;
      const endIdx = startIdx + pageSize;

      const pageRows = filteredRows.slice(startIdx, endIdx);
      pageRows.forEach((r) => (r.style.display = ""));

      return { startIdx, shown: pageRows.length, total: filteredRows.length };
    }

    function renderInfo(stats) {
      if (!info) return;
      if (stats.total === 0) {
        info.textContent = "No results";
        return;
      }
      const from = stats.startIdx + 1;
      const to = stats.startIdx + stats.shown;
      info.textContent = `Showing ${from}–${to} of ${stats.total}`;
    }

    function renderPager() {
      pager.innerHTML = "";
      const total = totalPages();

      const makeBtn = (label, disabled, onClick, active = false) => {
        const b = document.createElement("button");
        b.type = "button";
        b.className = "pager__btn" + (active ? " active" : "");
        b.textContent = label;
        b.disabled = disabled;
        b.addEventListener("click", onClick);
        pager.appendChild(b);
      };

      makeBtn("Prev", currentPage === 1, () => {
        currentPage = clamp(currentPage - 1, 1, total);
        render();
      });

      const maxBtns = 5;
      let start = Math.max(1, currentPage - 2);
      let end = Math.min(total, start + maxBtns - 1);
      start = Math.max(1, end - maxBtns + 1);

      for (let p = start; p <= end; p++) {
        makeBtn(String(p), false, () => {
          currentPage = p;
          render();
        }, p === currentPage);
      }

      makeBtn("Next", currentPage === total, () => {
        currentPage = clamp(currentPage + 1, 1, total);
        render();
      });
    }

    function clampPage() {
      const total = totalPages();
      currentPage = clamp(currentPage, 1, total);
    }

    function render() {
      clampPage();
      const stats = renderRows();
      renderInfo(stats);
      renderPager();
    }

    if (search) {
      on(search, "input", () => {
        applyFilter();
        render();
      });
    }

    applyFilter();
    render();
  }

  // init only if elements exist (safe)
  initTablePager({ tableId: "mainTable",  searchId: "tableSearch",  infoId: "tableInfo",  pagerId: "pager",      pageSize: 5 });
  initTablePager({ tableId: "rolesTable", searchId: "rolesSearch", infoId: "rolesInfo",  pagerId: "rolesPager", pageSize: 5 });

  /* =========================
     LOGS FILTER + PAGER
  ========================= */
  (function initLogs() {
    const typeSel = document.getElementById("logType");
    const table = document.getElementById("logsTable");
    if (!table || !typeSel) return;

    initTablePager({
      tableId: "logsTable",
      searchId: "logsSearch",
      infoId: "logsInfo",
      pagerId: "logsPager",
      pageSize: 6,
      extraFilterFn: (row) => {
        const t = typeSel.value;
        return (t === "all") || (row.dataset.type === t);
      }
    });

    on(typeSel, "change", () => {
      const search = document.getElementById("logsSearch");
      if (search) search.dispatchEvent(new Event("input"));
    });
  })();

  /* =========================
     UPLOADS (DROPZONE)
  ========================= */
  (function initUploads() {
    const dz = document.getElementById("dropzone");
    const input = document.getElementById("fileInput");
    const preview = document.getElementById("uploadPreview");
    const btnClear = document.getElementById("btnClear");
    const btnUpload = document.getElementById("btnUpload");
    if (!dz || !input || !preview) return;

    let files = [];

    function render() {
      if (!files.length) {
        preview.innerHTML = `<div class="muted">No files selected.</div>`;
        return;
      }

      preview.innerHTML = files.map((f) => {
        const sizeKB = Math.round(f.size / 1024);
        return `
          <div class="file-pill">
            <div>
              <div class="file-pill__name">${f.name}</div>
              <div class="file-pill__meta">${sizeKB} KB</div>
            </div>
            <button class="btn-sm btn-delete" type="button" data-remove="${f.name}">
              <i class="bi bi-x-lg"></i>
            </button>
          </div>
        `;
      }).join("");

      $$("[data-remove]", preview).forEach((btn) => {
        on(btn, "click", () => {
          const name = btn.getAttribute("data-remove");
          files = files.filter((x) => x.name !== name);
          render();
        });
      });
    }

    function addFiles(list) {
      Array.from(list || []).forEach((f) => {
        if (!files.some((x) => x.name === f.name)) files.push(f);
      });
      render();
    }

    on(dz, "click", () => input.click());

    on(input, "change", () => {
      addFiles(input.files);
      input.value = "";
    });

    on(dz, "dragover", (e) => { e.preventDefault(); dz.classList.add("is-dragover"); });
    on(dz, "dragleave", () => dz.classList.remove("is-dragover"));
    on(dz, "drop", (e) => {
      e.preventDefault();
      dz.classList.remove("is-dragover");
      addFiles(e.dataTransfer.files);
    });

    on(btnClear, "click", () => { files = []; render(); });

    on(btnUpload, "click", () => {
      alert(files.length ? `Uploading ${files.length} file(s) (demo)` : "No files selected");
    });

    render();
  })();

  /* =========================
     CALENDAR (DEMO)
  ========================= */
  (function initCalendar() {
    const grid = document.getElementById("calGrid");
    const title = document.getElementById("calTitle");
    const prev = document.getElementById("calPrev");
    const next = document.getElementById("calNext");
    const selectedEl = document.getElementById("calSelected");
    const eventTitle = document.getElementById("eventTitle");
    const addBtn = document.getElementById("addEventBtn");
    const eventList = document.getElementById("eventList");

    if (!grid || !title || !prev || !next || !selectedEl || !eventList) return;

    const events = {};
    const monthNames = ["January","February","March","April","May","June","July","August","September","October","November","December"];
    const dows = ["Sun","Mon","Tue","Wed","Thu","Fri","Sat"];

    let view = new Date();
    view.setDate(1);
    let selectedDate = null;

    const fmtDate = (date) => {
      const y = date.getFullYear();
      const m = String(date.getMonth() + 1).padStart(2, "0");
      const d = String(date.getDate()).padStart(2, "0");
      return `${y}-${m}-${d}`;
    };

    function renderEvents() {
      if (!selectedDate) {
        eventList.innerHTML = `<div class="muted">No day selected.</div>`;
        return;
      }

      const list = events[selectedDate] || [];
      if (!list.length) {
        eventList.innerHTML = `<div class="muted">No events for ${selectedDate}.</div>`;
        return;
      }

      eventList.innerHTML = list.map((t, idx) => `
        <div class="event-item">
          <div>
            <div class="event-item__title">${t}</div>
            <div class="event-item__meta">${selectedDate}</div>
          </div>
          <button class="btn-sm btn-delete" type="button" data-rm="${idx}">
            <i class="bi bi-trash"></i>
          </button>
        </div>
      `).join("");

      $$("[data-rm]", eventList).forEach((btn) => {
        on(btn, "click", () => {
          const i = parseInt(btn.getAttribute("data-rm"), 10);
          events[selectedDate].splice(i, 1);
          render();
        });
      });
    }

    function render() {
      const y = view.getFullYear();
      const m = view.getMonth();

      title.textContent = `${monthNames[m]} ${y}`;
      grid.innerHTML = "";

      dows.forEach((d) => {
        const h = document.createElement("div");
        h.className = "cal__dow";
        h.textContent = d;
        grid.appendChild(h);
      });

      const firstDay = new Date(y, m, 1);
      const startDow = firstDay.getDay();
      const daysInMonth = new Date(y, m + 1, 0).getDate();
      const daysPrevMonth = new Date(y, m, 0).getDate();

      for (let i = 0; i < 42; i++) {
        const cell = document.createElement("div");
        cell.className = "cal__cell";

        let dayNum;
        let cellDate;

        if (i < startDow) {
          dayNum = daysPrevMonth - (startDow - 1 - i);
          cellDate = new Date(y, m - 1, dayNum);
          cell.classList.add("is-muted");
        } else if (i >= startDow + daysInMonth) {
          dayNum = i - (startDow + daysInMonth) + 1;
          cellDate = new Date(y, m + 1, dayNum);
          cell.classList.add("is-muted");
        } else {
          dayNum = i - startDow + 1;
          cellDate = new Date(y, m, dayNum);
        }

        const key = fmtDate(cellDate);
        const has = (events[key] && events[key].length);

        cell.innerHTML = `
          <div class="cal__num">${dayNum}</div>
          ${has ? `<span class="cal__dot"></span>` : ``}
        `;

        if (selectedDate === key) cell.classList.add("is-selected");

        on(cell, "click", () => {
          selectedDate = key;
          selectedEl.textContent = `Selected: ${key}`;
          render();
        });

        grid.appendChild(cell);
      }

      renderEvents();
    }

    on(prev, "click", () => { view.setMonth(view.getMonth() - 1); render(); });
    on(next, "click", () => { view.setMonth(view.getMonth() + 1); render(); });

    on(addBtn, "click", () => {
      if (!selectedDate) return alert("Select a day first.");
      const t = (eventTitle?.value || "").trim();
      if (!t) return;

      events[selectedDate] = events[selectedDate] || [];
      events[selectedDate].push(t);
      if (eventTitle) eventTitle.value = "";
      render();
    });

    render();
  })();

  /* =========================
     COMPONENTS MODAL (DEMO)
  ========================= */
  (function initModal() {
    const modal = document.getElementById("demoModal");
    const openBtn = document.getElementById("openModalBtn");
    if (!modal || !openBtn) return;

    const close = () => {
      modal.classList.remove("open");
      modal.setAttribute("aria-hidden", "true");
    };

    on(openBtn, "click", () => {
      modal.classList.add("open");
      modal.setAttribute("aria-hidden", "false");
    });

    $$("[data-close='1']", modal).forEach((el) => on(el, "click", close));

    on(document, "keydown", (e) => {
      if (e.key === "Escape") close();
    });
  })();

  /* =========================
     ICONS PAGE (BOOTSTRAP ICONS JSON)
     - Put file: assets/fonts/bootstrap-icons.json
  ========================= */
  (function initIcons() {
    const input = document.getElementById("iconSearch");
    const grid = document.getElementById("iconGrid");
    const count = document.getElementById("iconCount");
    const toast = document.getElementById("toast");
    if (!grid || !count) return;

    const ICONS_JSON_PATH = "assets/fonts/bootstrap-icons.json";
    let allNames = [];

    function showToast(msg) {
      if (!toast) return;
      toast.textContent = msg;
      toast.classList.add("show");
      clearTimeout(showToast._t);
      showToast._t = setTimeout(() => toast.classList.remove("show"), 900);
    }

    async function copyText(text) {
      try {
        await navigator.clipboard.writeText(text);
      } catch {
        const ta = document.createElement("textarea");
        ta.value = text;
        document.body.appendChild(ta);
        ta.select();
        document.execCommand("copy");
        ta.remove();
      }
    }

    function render(list) {
      grid.innerHTML = list.map((name) => `
        <div class="icon-item" data-name="${name}" title="Click to copy: bi bi-${name}">
          <i class="bi bi-${name}"></i>
          <span>${name}</span>
        </div>
      `).join("");

      count.textContent = `Showing ${list.length} icons`;

      $$(".icon-item", grid).forEach((item) => {
        on(item, "click", async () => {
          const name = item.getAttribute("data-name");
          const cls = `bi bi-${name}`;
          await copyText(cls);
          showToast(`Copied: ${cls}`);
        });
      });
    }

    function applyFilter() {
      const q = (input?.value || "").toLowerCase().trim();
      const list = !q ? allNames : allNames.filter((n) => n.includes(q));
      render(list);
    }

    fetch(ICONS_JSON_PATH)
      .then((r) => {
        if (!r.ok) throw new Error("Missing bootstrap-icons.json");
        return r.json();
      })
      .then((json) => {
        allNames = Object.keys(json).sort();
        applyFilter();
      })
      .catch((err) => {
        console.error(err);
        count.textContent = "Error: cannot load bootstrap-icons.json";
        grid.innerHTML = `<div class="muted">Make sure you have: <strong>${ICONS_JSON_PATH}</strong></div>`;
      });

    on(input, "input", applyFilter);
  })();

  /* =========================
     WIDGETS (TIME / CPU / TODO / NOTES)
  ========================= */
  (function initWidgets() {
    const timeEl = document.getElementById("timeVal");
    const cpuVal = document.getElementById("cpuVal");
    const cpuBar = document.getElementById("cpuBar");

    const todoInput = document.getElementById("todoInput");
    const todoAdd = document.getElementById("todoAdd");
    const todoList = document.getElementById("todoList");

    const noteBox = document.getElementById("noteBox");
    const saveNote = document.getElementById("saveNote");
    const clearNote = document.getElementById("clearNote");
    const noteMsg = document.getElementById("noteMsg");

    // Time
    if (timeEl) {
      const tick = () => {
        const d = new Date();
        timeEl.textContent = d.toLocaleTimeString([], { hour: "2-digit", minute: "2-digit" });
      };
      tick();
      setInterval(tick, 1000);
    }

    // CPU demo
    if (cpuVal && cpuBar) {
      setInterval(() => {
        const v = Math.floor(20 + Math.random() * 70);
        cpuVal.textContent = `${v}%`;
        cpuBar.style.width = `${v}%`;
      }, 1200);
    }

    // Todo demo
    if (todoList) {
      let todos = [
        { t: "Review logs", done: false },
        { t: "Check uploads", done: true },
        { t: "Update roles", done: false },
      ];

      function renderTodos() {
        if (!todos.length) {
          todoList.innerHTML = `<div class="muted">No tasks.</div>`;
          return;
        }

        todoList.innerHTML = todos.map((x, i) => `
          <div class="todo-item">
            <div class="todo-item__t ${x.done ? "done" : ""}">${x.t}</div>
            <div style="display:flex; gap:8px;">
              <button class="btn-sm btn-edit" type="button" data-tog="${i}"><i class="bi bi-check2"></i></button>
              <button class="btn-sm btn-delete" type="button" data-del="${i}"><i class="bi bi-trash"></i></button>
            </div>
          </div>
        `).join("");

        $$("[data-tog]", todoList).forEach((b) => {
          on(b, "click", () => {
            const i = +b.getAttribute("data-tog");
            todos[i].done = !todos[i].done;
            renderTodos();
          });
        });

        $$("[data-del]", todoList).forEach((b) => {
          on(b, "click", () => {
            const i = +b.getAttribute("data-del");
            todos.splice(i, 1);
            renderTodos();
          });
        });
      }

      on(todoAdd, "click", () => {
        const t = (todoInput?.value || "").trim();
        if (!t) return;
        todos.unshift({ t, done: false });
        if (todoInput) todoInput.value = "";
        renderTodos();
      });

      on(todoInput, "keydown", (e) => {
        if (e.key === "Enter") {
          e.preventDefault();
          todoAdd?.click();
        }
      });

      renderTodos();
    }

    // Notes localStorage
    if (noteBox) noteBox.value = LS.get(KEY_NOTE) || "";

    on(saveNote, "click", () => {
      if (!noteBox) return;
      LS.set(KEY_NOTE, noteBox.value);
      if (noteMsg) noteMsg.textContent = "Saved.";
      setTimeout(() => { if (noteMsg) noteMsg.textContent = ""; }, 900);
    });

    on(clearNote, "click", () => {
      if (!noteBox) return;
      noteBox.value = "";
      LS.del(KEY_NOTE);
      if (noteMsg) noteMsg.textContent = "Cleared.";
      setTimeout(() => { if (noteMsg) noteMsg.textContent = ""; }, 900);
    });
  })();

  /* =========================
     SETTINGS PAGE (optional)
  ========================= */
  (function initSettings() {
    const themeSel = document.getElementById("setTheme");
    const compact = document.getElementById("setCompactSidebar");
    const sticky = document.getElementById("setStickyTopbar");
    const shadow = document.getElementById("setCardShadow");
    const btnSave = document.getElementById("btnSaveSettings");
    const btnReset = document.getElementById("btnResetSettings");
    const msg = document.getElementById("settingsMsg");
    if (!themeSel || !btnSave) return;

    function applySettings(s) {
      // Theme
      const t = THEMES.includes(s.theme) ? s.theme : "theme-default";
      setBodyTheme(t);

      // Compact sidebar
      const app = document.querySelector(".app");
      if (app) {
        app.classList.toggle("is-collapsed", !!s.compact);
        LS.set(KEY_COLLAPSED, s.compact ? "1" : "0");
      }

      // Sticky topbar
      const topbar = document.querySelector(".topbar");
      if (topbar) {
        topbar.style.position = (s.sticky === false) ? "static" : "sticky";
        topbar.style.top = "0";
      }

      // Shadow
      document.documentElement.style.setProperty(
        "--shadow",
        (s.shadow === false) ? "none" : "0 2px 8px rgba(0,0,0,.08)"
      );
    }

    function load() {
      const raw = LS.get(KEY_SETTINGS);
      const s = raw ? JSON.parse(raw) : {
        theme: getSavedTheme(),
        compact: LS.get(KEY_COLLAPSED) === "1",
        sticky: true,
        shadow: true
      };

      themeSel.value = THEMES.includes(s.theme) ? s.theme : "theme-default";
      if (compact) compact.checked = !!s.compact;
      if (sticky) sticky.checked = s.sticky !== false;
      if (shadow) shadow.checked = s.shadow !== false;

      applySettings(s);
    }

    function save() {
      const s = {
        theme: themeSel.value,
        compact: compact?.checked || false,
        sticky: sticky?.checked ?? true,
        shadow: shadow?.checked ?? true
      };

      LS.set(KEY_SETTINGS, JSON.stringify(s));
      applySettings(s);

      if (msg) msg.textContent = "Saved.";
      setTimeout(() => { if (msg) msg.textContent = ""; }, 900);
    }

    function reset() {
      LS.del(KEY_SETTINGS);
      themeSel.value = "theme-default";
      if (compact) compact.checked = false;
      if (sticky) sticky.checked = true;
      if (shadow) shadow.checked = true;
      save();
    }

    on(themeSel, "change", save);
    on(compact, "change", save);
    on(sticky, "change", save);
    on(shadow, "change", save);

    on(btnSave, "click", save);
    on(btnReset, "click", reset);

    load();
  })();

  /* =========================
     PROFILE PAGE (optional)
  ========================= */
  (function initProfileSettings() {
    const name = document.getElementById("setName");
    const email = document.getElementById("setEmail");
    const role = document.getElementById("setRole");
    const bio = document.getElementById("setBio");
    const btn = document.getElementById("btnSaveProfile");
    const msg = document.getElementById("profileMsg");
    if (!btn) return;

    function load() {
      const raw = LS.get(KEY_PROFILE);
      if (!raw) return;
      const p = JSON.parse(raw);
      if (name) name.value = p.name || "";
      if (email) email.value = p.email || "";
      if (role) role.value = p.role || "Administrator";
      if (bio) bio.value = p.bio || "";
    }

    function save() {
      const p = {
        name: name?.value || "",
        email: email?.value || "",
        role: role?.value || "Administrator",
        bio: bio?.value || ""
      };
      LS.set(KEY_PROFILE, JSON.stringify(p));
      if (msg) msg.textContent = "Profile saved.";
      setTimeout(() => { if (msg) msg.textContent = ""; }, 900);
    }

    on(btn, "click", save);
    load();
  })();

  /* =========================
     BLANK GRID (COLUMN SWITCHER)
  ========================= */
  (function initBlankGrid() {
    const sel = document.getElementById("gridCols");
    const grid = document.getElementById("demoGrid");
    if (!sel || !grid) return;

    function apply() {
      grid.className = `demo-grid demo-grid--${sel.value}`;
    }

    on(sel, "change", apply);
    apply();
  })();

})();