function productClicked(id){
    const url = new URL(document.location);
    const searchParams = url.searchParams;
    searchParams.append("id", id);
    window.history.pushState({}, '', url.toString());
    location.reload();
}