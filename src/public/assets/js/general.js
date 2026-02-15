
document.addEventListener('DOMContentLoaded', () => {
    logout();
});

function logout() {
    document.getElementById('logout_btn').addEventListener('click', () => {
        fetch('/logout.php', {
            method: 'POST',
            credentials: 'include'
        })
            .then(res => res.json())
            .then(data => {
                console.log(data.message);
                //suppression du token côté client
                localStorage.removeItem('token');
                window.location.href = '/login.html';
            })
            .catch(err => console.error('Erreur logout', err));
    });
}
