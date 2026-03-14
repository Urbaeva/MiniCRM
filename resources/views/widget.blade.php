<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Обратная связь</title>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }
        .widget {
            background: #fff;
            border-radius: 1rem;
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
            width: 100%;
            max-width: 480px;
            padding: 2rem;
        }
        .widget h2 {
            font-size: 1.5rem;
            color: #1e293b;
            margin-bottom: 0.25rem;
        }
        .widget p.subtitle {
            color: #64748b;
            font-size: 0.875rem;
            margin-bottom: 1.5rem;
        }
        .form-group { margin-bottom: 1rem; }
        .form-group label {
            display: block;
            font-size: 0.85rem;
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.25rem;
        }
        .form-control {
            width: 100%;
            padding: 0.6rem 0.75rem;
            border: 1.5px solid #e2e8f0;
            border-radius: 0.5rem;
            font-size: 0.9rem;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .form-control:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102,126,234,0.15);
        }
        textarea.form-control { resize: vertical; min-height: 100px; }
        .form-control.is-invalid { border-color: #ef4444; }
        .invalid-feedback { color: #ef4444; font-size: 0.78rem; margin-top: 0.2rem; }
        .btn-submit {
            width: 100%;
            padding: 0.7rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #fff;
            border: none;
            border-radius: 0.5rem;
            font-size: 0.95rem;
            font-weight: 600;
            cursor: pointer;
            transition: opacity 0.2s;
        }
        .btn-submit:hover { opacity: 0.9; }
        .btn-submit:disabled { opacity: 0.6; cursor: not-allowed; }
        .file-input-wrapper { position: relative; }
        .file-input-wrapper input[type="file"] { font-size: 0.85rem; }
        .file-hint { color: #94a3b8; font-size: 0.75rem; margin-top: 0.2rem; }
        .message {
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1rem;
            font-size: 0.875rem;
            display: none;
        }
        .message-success { background: #d1fae5; color: #065f46; }
        .message-error { background: #fee2e2; color: #991b1b; }
        .message.visible { display: block; }
        .success-state { text-align: center; padding: 2rem 0; }
        .success-state .checkmark { font-size: 3rem; margin-bottom: 0.75rem; }
        .success-state h3 { color: #065f46; font-size: 1.25rem; margin-bottom: 0.5rem; }
        .success-state p { color: #6b7280; font-size: 0.875rem; }
        .success-state button { margin-top: 1rem; background: none; border: 1.5px solid #667eea; color: #667eea; padding: 0.5rem 1.5rem; border-radius: 0.5rem; cursor: pointer; font-weight: 600; }
    </style>
</head>
<body>
    <div class="widget">
        <div id="form-container">
            <h2>Обратная связь</h2>
            <p class="subtitle">Заполните форму и мы свяжемся с вами в ближайшее время.</p>

            <div id="error-message" class="message message-error"></div>

            <form id="ticket-form" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="name">Имя *</label>
                    <input type="text" id="name" name="name" class="form-control" required>
                    <div class="invalid-feedback" data-field="name"></div>
                </div>

                <div class="form-group">
                    <label for="email">Электронная почта</label>
                    <input type="email" id="email" name="email" class="form-control">
                    <div class="invalid-feedback" data-field="email"></div>
                </div>

                <div class="form-group">
                    <label for="phone">Телефон (формат: +79001234567)</label>
                    <input type="tel" id="phone" name="phone" class="form-control" placeholder="+79001234567">
                    <div class="invalid-feedback" data-field="phone"></div>
                </div>

                <div class="form-group">
                    <label for="subject">Тема *</label>
                    <input type="text" id="subject" name="subject" class="form-control" required>
                    <div class="invalid-feedback" data-field="subject"></div>
                </div>

                <div class="form-group">
                    <label for="body">Сообщение *</label>
                    <textarea id="body" name="body" class="form-control" required></textarea>
                    <div class="invalid-feedback" data-field="body"></div>
                </div>

                <div class="form-group">
                    <label>Прикрепить файлы</label>
                    <div class="file-input-wrapper">
                        <input type="file" id="files" name="files[]" multiple>
                    </div>
                    <div class="file-hint">Макс. 5 файлов, до 10 МБ каждый</div>
                    <div class="invalid-feedback" data-field="files"></div>
                </div>

                <button type="submit" class="btn-submit" id="submit-btn">Отправить заявку</button>
            </form>
        </div>

        <div id="success-container" class="success-state" style="display:none;">
            <div class="checkmark">&#10003;</div>
            <h3>Заявка отправлена!</h3>
            <p>Спасибо за обращение. Мы рассмотрим вашу заявку в ближайшее время.</p>
            <button onclick="resetForm()">Отправить ещё</button>
        </div>
    </div>

    <script>
        const form = document.getElementById('ticket-form');
        const submitBtn = document.getElementById('submit-btn');
        const errorMessage = document.getElementById('error-message');
        const formContainer = document.getElementById('form-container');
        const successContainer = document.getElementById('success-container');

        form.addEventListener('submit', async function(e) {
            e.preventDefault();
            clearErrors();

            submitBtn.disabled = true;
            submitBtn.textContent = 'Отправка...';

            const formData = new FormData(form);

            try {
                const response = await fetch('/api/tickets', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'Accept': 'application/json',
                    },
                });

                const data = await response.json();

                if (!response.ok) {
                    if (response.status === 422 && data.errors) {
                        showValidationErrors(data.errors);
                    } else {
                        showError(data.message || 'Произошла ошибка при отправке заявки.');
                    }
                    return;
                }

                formContainer.style.display = 'none';
                successContainer.style.display = 'block';
            } catch (err) {
                showError('Ошибка сети. Попробуйте позже.');
            } finally {
                submitBtn.disabled = false;
                submitBtn.textContent = 'Отправить заявку';
            }
        });

        function showValidationErrors(errors) {
            for (const [field, messages] of Object.entries(errors)) {
                const cleanField = field.replace(/\.\d+$/, '');
                const input = form.querySelector(`[name="${cleanField}"], [name="${cleanField}[]"]`);
                if (input) {
                    input.classList.add('is-invalid');
                }
                const feedback = form.querySelector(`[data-field="${cleanField}"]`);
                if (feedback) {
                    feedback.textContent = messages[0];
                }
            }
        }

        function showError(msg) {
            errorMessage.textContent = msg;
            errorMessage.classList.add('visible');
        }

        function clearErrors() {
            errorMessage.classList.remove('visible');
            form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
            form.querySelectorAll('.invalid-feedback').forEach(el => el.textContent = '');
        }

        function resetForm() {
            form.reset();
            clearErrors();
            successContainer.style.display = 'none';
            formContainer.style.display = 'block';
        }
    </script>
</body>
</html>
