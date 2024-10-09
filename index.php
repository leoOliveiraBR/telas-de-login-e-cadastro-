<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro Novo Usuário</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url("img-telas/camaAZUL.png");
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-size: cover; /* Ajusta a imagem para cobrir todo o elemento */
            background-position: center; /* Centraliza a imagem */
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            max-width: 400px;
            padding: 20px;
            text-align: center;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333333;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        input[type="text"],
        input[type="date"],
        input[type="email"],
        input[type="password"] {
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input.error {
            border: 1px solid red; /* Estilo para a caixa de erro */
        }

        .error-message {
            color: red;
            font-size: 12px;
            margin-bottom: 10px;
            display: none; /* Inicialmente escondido */
        }

        button {
            padding: 10px;
            background-color: #000000;
            color: #ffee00;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .links {
            text-align: center;
            margin-top: 20px;
        }

        .links a {
            display: block;
            margin-bottom: 10px;
            color: #000000;
            text-decoration: none;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('register-button').addEventListener('click', function(event) {
                event.preventDefault(); // Evita o envio do formulário para validação

                var inputs = document.querySelectorAll('input[required]');
                var allValid = true;

                function validateInput(input) {
                    var errorMessage = input.nextElementSibling; // Seleciona a mensagem de erro
                    if (input.value.trim() === '') {
                        input.classList.add('error');
                        errorMessage.style.display = 'block';
                        allValid = false;
                    } else {
                        input.classList.remove('error');
                        errorMessage.style.display = 'none';
                    }
                }

                inputs.forEach(validateInput);

                if (allValid) {
                    // Se todos os campos forem válidos, envia o formulário
                    document.getElementById('register-form').submit(); 
                }
            });
        });

        function verificarEmail() {
            const emailInput = document.querySelector('input[name="email"]');
            const email = emailInput.value;

            if (email) {
                fetch('controller/check_email.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'email=' + encodeURIComponent(email),
                })
                .then(response => response.text())
                .then(data => {
                    const emailErrorDiv = emailInput.nextElementSibling;
                    if (data === 'exists') {
                        emailInput.classList.add('error');
                        emailErrorDiv.textContent = "Este e-mail já está registrado.";
                        emailErrorDiv.style.display = 'block';
                    } else {
                        emailInput.classList.remove('error');
                        emailErrorDiv.style.display = 'none';
                    }
                })
                .catch(error => {
                    console.error('Erro:', error);
                });
            }
        }
    </script>
</head>

<body>
    <div class="container">
        <form id="register-form" action="controller/salvarCAD.php" method="POST">
            <h2>Registrar</h2>
            <input type="text" id="name" name="name" placeholder="Nome:" required>
            <div class="error-message">Digite um nome, por favor.</div>
            
            <input type="date" id="dob" name="dob" placeholder="Data de Nascimento:" required>
            <div class="error-message">Selecione uma data de nascimento.</div>
            
            <input type="email" id="email" name="email" placeholder="E-mail:" required onblur="verificarEmail()">
            <div class="error-message">Digite um e-mail válido.</div>
            <div class="error-message" id="email-error-message"><?php echo $errorMessage; ?></div> <!-- Mensagem de erro para o e-mail -->
            
            <input type="password" id="password" name="password" placeholder="Senha:" required>
            <div class="error-message">Digite uma senha, por favor.</div>
            
            <input type="password" id="confirm-password" name="confirm-password" placeholder="Confirmar Senha:" required>
            <div class="error-message">Confirme sua senha, por favor.</div>
            
            <button id="register-button" type="button">Registrar</button>
            
            <div class="links">
                <a href="#">Esqueceu a Senha?</a>
                <a href="#">Já tem uma conta? Faça login</a>
            </div>
        </form>
    </div>
</body>
</html>
