document.addEventListener("DOMContentLoaded", function () {
    let pagination = document.getElementsByClassName("js-pagination")[0];
    let maxPage = parseInt(document.getElementsByClassName("js-pagination")[0].dataset.maxPage);
    let currentPage = parseInt(document.getElementsByClassName("js-pagination")[0].dataset.currentPage);

    let linkPart = window.location.search;
    if (linkPart === '') {
        linkPart = '?';
    } else {
        linkPart = linkPart.replace(/&?page=[\d]*/, '') + '&';
    }

    let pageIndent = 5;
    let start = currentPage - pageIndent < 1 ? 1 : currentPage - pageIndent;
    let end = currentPage + pageIndent > maxPage ? maxPage : currentPage + pageIndent;

    for (let i = start; i <= end; i++) {
        let link = document.createElement('a');
        link.href = linkPart + "page=" + i;
        link.innerText = i;
        if (i == currentPage) {
            link.className = "current";
        }
        pagination.appendChild(link);
    }
});