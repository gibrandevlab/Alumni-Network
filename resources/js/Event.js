document.getElementById("see-all").addEventListener("click", function() {
    document.getElementById("additional-cards").classList.remove("hidden");
    document.getElementById("minimize-all").classList.remove("hidden");
    this.style.display = "none";
});

document.getElementById("minimize-all").addEventListener("click", function() {
    document.getElementById("additional-cards").classList.add("hidden");
    this.classList.add("hidden");
    document.getElementById("see-all").style.display = "inline-block";
});

document.getElementById("see-all-loker").addEventListener("click", function() {
    document.getElementById("additional-loker").classList.remove("hidden");
    document.getElementById("minimize-all-loker").classList.remove("hidden");
    this.style.display = "none";
});

document.getElementById("minimize-all-loker").addEventListener("click", function() {
    document.getElementById("additional-loker").classList.add("hidden");
    this.classList.add("hidden");
    document.getElementById("see-all-loker").style.display = "inline-block";
});
