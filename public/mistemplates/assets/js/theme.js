
const themes = [
  "theme-default",
  "theme-blue",
  "theme-softblue",
  "theme-dark",
  "theme-purple",
  "theme-blueorange" // ✅ add this
];

function applyTheme(theme){
  document.body.classList.remove(...themes);
  document.body.classList.add(theme);
  localStorage.setItem("adminTheme", theme);
}

// load saved theme
const saved = localStorage.getItem("adminTheme") || "theme-default";
applyTheme(saved);

// toggle panel
const themeBtn = document.getElementById("themeBtn");
const themePanel = document.getElementById("themePanel");

themeBtn.addEventListener("click", () => {
  themePanel.style.display =
    themePanel.style.display === "block" ? "none" : "block";
});

// select theme
document.querySelectorAll(".theme-option").forEach(btn => {
  btn.addEventListener("click", () => {
    applyTheme(btn.dataset.theme);
    themePanel.style.display = "none";
  });
});

// click outside to close
document.addEventListener("click", function(e){
  if(!themePanel.contains(e.target) && !themeBtn.contains(e.target)){
    themePanel.style.display = "none";
  }
});