document.querySelectorAll('.remove').forEach(function (element) {
    element.addEventListener('click', remove);
});

function remove(event)
{
    event.preventDefault();
    fetch(this.href)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert(data.message);
            }
        });
}