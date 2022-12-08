document.onkeydown = function(e){
    if (e.key == "Escape"){
        closeModal();
    }
};

function closeModal() {
    const url = new URL(document.location);
    const searchParams = url.searchParams;
    searchParams.delete("id");
    window.history.pushState({}, '', url.toString());
    location.reload();
}