
<x-staff>
    <div class="container-fluid py-4 it-assistant">

        {{-- PAGE HEADER --}}
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
            <div>
                <h3 class="fw-bold mb-1">
                    <i class="bi bi-robot text-primary me-2"></i>
                    Basic Chat Assistant
                </h3>
                <p class="text-muted mb-0">
                    Get help with IT problems and troubleshooting.
                </p>
            </div>

            <button type="button" id="clearChat"
                    class="btn btn-outline-secondary">
                <i class="bi bi-arrow-counterclockwise me-1"></i>
                New Conversation
            </button>
        </div>

        {{-- CHAT CARD --}}
        <div class="card assistant-card shadow-sm border-0">

            {{-- HEADER --}}
            <div class="assistant-header p-3 d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-3">
                    <div class="assistant-avatar">
                        <i class="bi bi-robot"></i>
                    </div>

                    <div>
                        <h6 class="fw-bold mb-1">IT Services Assistant</h6>
                        <small class="assistant-status">
                            <span class="status-dot"></span>
                            Ready to help
                        </small>
                    </div>
                </div>

                <span class="badge bg-light text-primary">AI Assistant</span>
            </div>

            {{-- MESSAGES --}}
            <div id="chatMessages"
                 class="chat-messages"
                 role="log"
                 aria-live="polite"
                 aria-label="Chat conversation">

                <div class="message-row assistant-row">
                    <div class="message-avatar">
                        <i class="bi bi-robot"></i>
                    </div>

                    <div class="message-content">
                        <div class="message-name">IT Assistant</div>

                        <div class="message-bubble">
                            Hello! Welcome to the IT Services Assistant.

                            <br><br>

                            I can help you troubleshoot internet connectivity,
                            printers, computers, email, software, and other
                            IT concerns.

                            <br><br>

                            What problem are you experiencing today?
                        </div>

                        <small class="message-time">AI Support</small>
                    </div>
                </div>
            </div>

            {{-- TYPING INDICATOR --}}
            <div id="typingIndicator"
                 class="typing-indicator px-4 py-3"
                 hidden>
                <div class="typing-dots">
                    <span></span><span></span><span></span>
                </div>
                <small class="text-muted">Assistant is thinking...</small>
            </div>

            {{-- QUICK QUESTIONS --}}
            <div class="suggestion-area p-3">
                <div class="d-flex justify-content-between flex-wrap gap-2 mb-2">
                    <small class="fw-semibold text-secondary">
                        COMMON IT CONCERNS
                    </small>
                    <small class="text-muted">
                        Select a question to begin
                    </small>
                </div>

                <div class="d-flex flex-wrap gap-2">
                    <button type="button" class="suggestion-chip"
                            data-message="My computer has no internet connection.">
                        <i class="bi bi-wifi me-1"></i> No Internet
                    </button>

                    <button type="button" class="suggestion-chip"
                            data-message="My printer is not printing.">
                        <i class="bi bi-printer me-1"></i> Printer Problem
                    </button>

                    <button type="button" class="suggestion-chip"
                            data-message="My computer is running very slowly.">
                        <i class="bi bi-pc-display me-1"></i> Slow Computer
                    </button>

                    <button type="button" class="suggestion-chip"
                            data-message="I cannot access my university email.">
                        <i class="bi bi-envelope me-1"></i> Email Problem
                    </button>

                    <button type="button" class="suggestion-chip"
                            data-message="I need help installing software.">
                        <i class="bi bi-download me-1"></i> Software Installation
                    </button>

                    <button type="button" class="suggestion-chip"
                            data-message="My computer cannot connect to the university network.">
                        <i class="bi bi-router me-1"></i> Network Problem
                    </button>
                </div>
            </div>

            {{-- INPUT --}}
            <form id="chatForm" class="chat-input-area p-3">
                @csrf

                <div class="chat-input-wrapper">
                    <textarea
                        id="chatInput"
                        class="form-control"
                        rows="1"
                        maxlength="2000"
                        placeholder="Describe your IT concern..."
                        aria-label="Type your message"
                        required></textarea>

                    <button type="submit" id="sendButton"
                            class="btn btn-primary send-button">
                        <i class="bi bi-send-fill"></i>
                        <span class="ms-1">Send</span>
                    </button>
                </div>

                <div class="d-flex justify-content-between flex-wrap gap-2 mt-2">
                    <small class="text-muted">
                        <i class="bi bi-shield-check me-1"></i>
                        Never share passwords or OTPs.
                    </small>

                    <small class="text-muted">
                        Enter to send · Shift + Enter for a new line
                    </small>
                </div>
            </form>
        </div>

        {{-- TICKET HANDOFF --}}
        <div class="card ticket-card shadow-sm border-0 mt-3">
            <div class="card-body d-flex justify-content-between
                        align-items-center flex-wrap gap-3">

                <div class="d-flex align-items-center gap-3">
                    <div class="ticket-icon">
                        <i class="bi bi-ticket-perforated"></i>
                    </div>

                    <div>
                        <h6 class="fw-bold mb-1">Need further assistance?</h6>
                        <p class="text-muted small mb-0">
                            Submit an IT support ticket if your problem persists.
                        </p>
                    </div>
                </div>

                {{-- Replace this URL with your actual ticket creation route. --}}
                <a href="{{ route('ticket-staff.index') }}"
                   id="createTicketLink"
                   class="btn btn-outline-primary">
                    <i class="bi bi-plus-circle me-1"></i>
                    Create Services Request
                </a>
            </div>
        </div>
    </div>

    {{-- STYLES --}}
    <style>
        .it-assistant {
            color: #1e293b;
        }

        .assistant-card,
        .ticket-card {
            border-radius: 14px;
            overflow: hidden;
        }

        .assistant-header {
            background: #17365d;
            color: #fff;
        }

        .assistant-avatar {
            width: 46px;
            height: 46px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 13px;
            background: rgba(255,255,255,.14);
            font-size: 25px;
        }

        .assistant-status {
            color: #dbeafe;
            font-size: 12px;
        }

        .status-dot {
            display: inline-block;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #4ade80;
            margin-right: 5px;
        }

        .chat-messages {
            height: 430px;
            overflow-y: auto;
            padding: 24px;
            background: #f8fafc;
            scroll-behavior: smooth;
        }

        .message-row {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            margin-bottom: 22px;
        }

        .user-row {
            justify-content: flex-end;
        }

        .message-avatar {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background: #e2e8f0;
            color: #17365d;
            font-size: 17px;
        }

        .message-content {
            min-width: 0;
            max-width: min(80%, 680px);
        }

        .user-row .message-content {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
        }

        .message-name {
            font-size: 12px;
            font-weight: 600;
            color: #64748b;
            margin-bottom: 5px;
        }

        .message-bubble {
            padding: 12px 16px;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            border-bottom-left-radius: 4px;
            background: #fff;
            color: #1e293b;
            line-height: 1.65;
            white-space: pre-wrap;
            overflow-wrap: anywhere;
        }

        .user-row .message-bubble {
            background: #17365d;
            color: #fff;
            border-color: #17365d;
            border-radius: 14px 14px 4px 14px;
        }

        .message-time {
            display: block;
            margin-top: 5px;
            color: #64748b;
            font-size: 11px;
        }

        .suggestion-area {
            background: #fff;
            border-top: 1px solid #e2e8f0;
        }

        .suggestion-chip {
            padding: 7px 12px;
            border: 1px solid #cbd5e1;
            border-radius: 20px;
            background: #fff;
            color: #334155;
            font-size: 13px;
            cursor: pointer;
            transition: background .2s, border-color .2s;
        }

        .suggestion-chip:hover {
            background: #eff6ff;
            border-color: #93c5fd;
        }

        .suggestion-chip:disabled {
            opacity: .55;
            cursor: not-allowed;
        }

        .chat-input-area {
            background: #fff;
            border-top: 1px solid #e2e8f0;
        }

        .chat-input-wrapper {
            display: flex;
            align-items: flex-end;
            gap: 10px;
        }

        #chatInput {
            resize: none;
            min-height: 44px;
            max-height: 120px;
            padding: 11px 14px;
        }

        .send-button {
            min-height: 44px;
            white-space: nowrap;
        }

        .typing-indicator {
            align-items: center;
            gap: 9px;
            background: #f8fafc;
        }

        .typing-indicator:not([hidden]) {
            display: flex;
        }

        .typing-dots {
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .typing-dots span {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: #64748b;
            animation: typingPulse .8s infinite alternate;
        }

        .typing-dots span:nth-child(2) {
            animation-delay: .2s;
        }

        .typing-dots span:nth-child(3) {
            animation-delay: .4s;
        }

        @keyframes typingPulse {
            from { opacity: .3; transform: translateY(0); }
            to { opacity: 1; transform: translateY(-3px); }
        }

        .ticket-card {
            border-radius: 12px;
        }

        .ticket-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 44px;
            height: 44px;
            flex-shrink: 0;
            border-radius: 12px;
            background: #eff6ff;
            color: #2563eb;
            font-size: 22px;
        }

        .ticket-suggestion {
            margin: 0 0 22px 45px;
            padding: 15px;
            background: #fff;
            border: 1px solid #cbd5e1;
            border-radius: 12px;
        }

        .ticket-suggestion textarea {
            width: 100%;
            min-height: 90px;
            margin: 10px 0;
            padding: 10px;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            resize: vertical;
        }

        @media (max-width: 576px) {
            .chat-messages {
                height: 55vh;
                min-height: 300px;
                padding: 14px;
            }

            .message-content {
                max-width: 90%;
            }

            .chat-input-wrapper {
                align-items: stretch;
            }

            .send-button {
                padding: 10px;
            }
        }
    </style>

    {{-- JAVASCRIPT --}}
    <script>
    (() => {
        const root = document.querySelector('.it-assistant');

        if (!root || root.dataset.initialized === 'true') {
            return;
        }

        root.dataset.initialized = 'true';

        const form = root.querySelector('#chatForm');
        const input = root.querySelector('#chatInput');
        const messagesContainer = root.querySelector('#chatMessages');
        const typingIndicator = root.querySelector('#typingIndicator');
        const sendButton = root.querySelector('#sendButton');
        const clearButton = root.querySelector('#clearChat');
        const suggestionButtons = root.querySelectorAll('.suggestion-chip');
        const ticketLink = root.querySelector('#createTicketLink');

        const chatUrl = @json(route('staff.chat-assistant.chat'));
        const csrfToken = @json(csrf_token());

        let history = [];
        let sending = false;

        function scrollToBottom() {
            messagesContainer.scrollTop =
                messagesContainer.scrollHeight;
        }

        function setBusy(busy) {
            sending = busy;
            sendButton.disabled = busy;
            input.disabled = busy;
            clearButton.disabled = busy;

            suggestionButtons.forEach(button => {
                button.disabled = busy;
            });

            typingIndicator.hidden = !busy;
        }

        function addMessage(role, content) {
            const row = document.createElement('div');

            row.className = 'message-row ' +
                (role === 'user' ? 'user-row' : 'assistant-row');

            if (role !== 'user') {
                const avatar = document.createElement('div');
                avatar.className = 'message-avatar';

                const icon = document.createElement('i');
                icon.className = 'bi bi-robot';

                avatar.appendChild(icon);
                row.appendChild(avatar);
            }

            const wrapper = document.createElement('div');
            wrapper.className = 'message-content';

            const name = document.createElement('div');
            name.className = 'message-name';
            name.textContent = role === 'user' ? 'You' : 'IT Assistant';

            const bubble = document.createElement('div');
            bubble.className = 'message-bubble';

            // Render responses as text, never as executable HTML.
            bubble.textContent = content;

            const time = document.createElement('small');
            time.className = 'message-time';
            time.textContent = role === 'user' ? 'You' : 'AI Support';

            wrapper.appendChild(name);
            wrapper.appendChild(bubble);
            wrapper.appendChild(time);
            row.appendChild(wrapper);

            messagesContainer.appendChild(row);
            scrollToBottom();

            return row;
        }

        function addTicketSuggestion(description) {
            const container = document.createElement('div');
            container.className = 'ticket-suggestion';

            const heading = document.createElement('h6');
            heading.className = 'fw-bold mb-1';
            heading.textContent = 'Need further assistance?';

            const explanation = document.createElement('p');
            explanation.className = 'text-muted small mb-2';
            explanation.textContent =
                'Review this suggested description before proceeding to the ticket form.';

            container.appendChild(heading);
            container.appendChild(explanation);

            if (description) {
                const label = document.createElement('label');
                label.className = 'small fw-semibold';
                label.textContent = 'Suggested ticket description';

                const textarea = document.createElement('textarea');
                textarea.value = description;
                textarea.maxLength = 2000;
                textarea.setAttribute(
                    'aria-label',
                    'Suggested ticket description'
                );

                container.appendChild(label);
                container.appendChild(textarea);
            }

            const link = document.createElement('a');
            link.href = ticketLink.href;
            link.className = 'btn btn-primary btn-sm';
            link.textContent = 'Continue to Create IT Ticket';

            container.appendChild(link);
            messagesContainer.appendChild(container);

            scrollToBottom();
        }

        function getRequestHistory(message) {
            const payload = [
                ...history,
                { role: 'user', content: message }
            ].slice(-12);

            // The backend expects the first message to be from the user.
            while (payload.length && payload[0].role !== 'user') {
                payload.shift();
            }

            return payload;
        }

        async function sendMessage(rawMessage) {
            const message = rawMessage.trim();

            if (!message || sending) {
                return;
            }

            addMessage('user', message);
            input.value = '';
            input.style.height = 'auto';

            setBusy(true);

            try {
                const response = await fetch(chatUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        messages: getRequestHistory(message)
                    })
                });

                const data = await response.json();

                if (!response.ok || !data.success) {
                    throw new Error(
                        data.message ||
                        'The assistant could not process your message.'
                    );
                }

                // ITChatAssistant returns its result under data.data.
                const result = data.data;

                if (!result || typeof result.reply !== 'string') {
                    throw new Error('The assistant returned an invalid response.');
                }

                history.push(
                    { role: 'user', content: message },
                    { role: 'assistant', content: result.reply }
                );

                // Keep recent conversation turns and preserve a user first.
                history = history.slice(-12);

                while (history.length && history[0].role !== 'user') {
                    history.shift();
                }

                addMessage('assistant', result.reply);

                if (result.ticket_required === true) {
                    addTicketSuggestion(
                        typeof result.suggested_ticket_description === 'string'
                            ? result.suggested_ticket_description
                            : ''
                    );
                }

            } catch (error) {
                addMessage(
                    'assistant',
                    error.message ||
                    'Unable to connect to the IT assistant. Please try again.'
                );

            } finally {
                setBusy(false);
                input.focus();
            }
        }

        form.addEventListener('submit', event => {
            event.preventDefault();
            sendMessage(input.value);
        });

        input.addEventListener('input', () => {
            input.style.height = 'auto';
            input.style.height =
                Math.min(input.scrollHeight, 120) + 'px';
        });

        input.addEventListener('keydown', event => {
            if (event.key === 'Enter' && !event.shiftKey) {
                event.preventDefault();
                form.requestSubmit();
            }
        });

        suggestionButtons.forEach(button => {
            button.addEventListener('click', () => {
                sendMessage(button.dataset.message || '');
            });
        });

        clearButton.addEventListener('click', () => {
            if (sending) {
                return;
            }

            history = [];
            messagesContainer.replaceChildren();

            const welcome = addMessage(
                'assistant',
                'Hello! Welcome to the IT Services Assistant. ' +
                'What IT problem can I help you with today?'
            );

            welcome.querySelector('.message-name').textContent =
                'IT Assistant';

            input.value = '';
            input.focus();
        });
    })();
    </script>
</x-staff>
