document.querySelector('#search').addEventListener('input', () => {
    const itens = document.querySelectorAll('.crud-item,.mission-item');
    const search = document.querySelector('#search').value;
    const regex = new RegExp(search, 'i');

    itens.forEach(item => {
        if (regex.test(item.querySelector('.crud-title,.mission-title').innerHTML)) {
            item.style.display = 'flex';
        } else {
            item.style.display = 'none';
        }
    });

    if (search.length === 0) {
        itens.forEach(item => {
            item.style.display = 'flex';
        });
    }
});