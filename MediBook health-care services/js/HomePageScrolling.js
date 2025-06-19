
    document
    .getElementById("learnMoreBtn")
    .addEventListener("click", function (e) {
    e.preventDefault();
    const container = document.getElementById("services");
    container.scrollIntoView({ behavior: "smooth" });

    setTimeout(() => {
    container.scrollBy({
    left: container.offsetWidth,
    behavior: "smooth",
});
}, 600);
});
