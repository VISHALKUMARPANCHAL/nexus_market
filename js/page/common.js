// alert('1');
function onrangeupdate(val) {
    document.getElementById('rangespan').textContent = val;
}

function oncolorupdate(val) {
    document.getElementById('colorspan').textContent = val;
}
    document.addEventListener("DOMContentLoaded", function() {
        const backToTopButton = document.getElementById("scrollToTop");

        window.addEventListener("scroll", function() {
            if (window.scrollY > 300) {
                backToTopButton.style.display = "block";
            } else {
                backToTopButton.style.display = "none";
            }
        });

        backToTopButton.addEventListener("click", function() {
            window.scrollTo({
                top: 0,
                behavior: "smooth"
            });
        });
    });