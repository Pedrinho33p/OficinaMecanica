const signUpButton = document.getElementById('signUp');
const signInButton = document.getElementById('signIn');
const container = document.getElementById('container');
const signupForm = document.getElementById('signupForm');
const signinForm = document.getElementById('signinForm');

// Lógica de transição visual entre os painéis de login e cadastro
signUpButton.addEventListener('click', () => {
    container.classList.add("right-panel-active");
});

signInButton.addEventListener('click', () => {
    container.classList.remove("right-panel-active");
});

// Envio do formulário de cadastro (Sign Up)
signupForm.addEventListener('submit', async (e) => {
    e.preventDefault(); // Impede o envio padrão do formulário

    const username = document.getElementById('signup-username').value;
    const email = document.getElementById('signup-email').value;
    const password = document.getElementById('signup-password').value;

    const formData = new FormData();
    formData.append('username', username);
    formData.append('email', email);
    formData.append('password', password);
    formData.append('action', 'signup'); // Ação para o PHP

    try {
        const response = await fetch('process.php', {
            method: 'POST',
            body: formData
        });

        const result = await response.text();
        document.body.innerHTML = result; // Exibe a resposta do PHP na tela
    } catch (error) {
        console.error('Erro:', error);
        document.body.innerHTML = "<h1>Erro de Conexão</h1><p>Não foi possível conectar-se ao servidor.</p>";
    }
});

// Envio do formulário de login (Sign In)
signinForm.addEventListener('submit', async (e) => {
    e.preventDefault(); // Impede o envio padrão do formulário

    const username = document.getElementById('signin-username').value;
    const password = document.getElementById('signin-password').value;

    const formData = new FormData();
    formData.append('username', username);
    formData.append('password', password);
    formData.append('action', 'signin'); // Ação para o PHP

    try {
        const response = await fetch('process.php', {
            method: 'POST',
            body: formData
        });

        const result = await response.text();
        document.body.innerHTML = result; // Exibe a resposta do PHP na tela
    } catch (error) {
        console.error('Erro:', error);
        document.body.innerHTML = "<h1>Erro de Conexão</h1><p>Não foi possível conectar-se ao servidor.</p>";
    }
});