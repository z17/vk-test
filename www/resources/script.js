document.addEventListener("DOMContentLoaded", function () {
    let pagination = document.getElementsByClassName("js-pagination")[0];
    let maxPage = document.getElementsByClassName("js-pagination")[0].dataset.maxPage;
    let currentPage = document.getElementsByClassName("js-pagination")[0].dataset.currentPage;

    let linkPart = window.location.search;
    if (linkPart === '') {
        linkPart = '?';
    } else {
        linkPart = linkPart.replace(/&?page=[\d]*/, '') + '&';
    }

    for (let i = 1; i <= maxPage; i++) {
        let link = document.createElement('a');
        link.href = linkPart + "page=" + i;
        link.innerText = i;
        if (i == currentPage) {
            link.className = "current";
        }
        pagination.appendChild(link);
    }
});