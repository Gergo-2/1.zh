var form = document.getElementById("java");
var hom = document.getElementById('hom');
var a = hom.value;
hom.addEventListener("change",(e)=>{
    
    hom.value=e.target.value;
});
form.addEventListener("submit", (e) => {
    
    if (parseInt(hom.value) < -10 || parseInt(hom.value) > 50) {
        e.preventDefault();
        alert("Érvénytelen hőmérséklet");
    }
})