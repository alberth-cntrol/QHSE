function loadImage(url) {
    return new Promise(resolve => {
        const xhr = new XMLHttpRequest();
        xhr.open('GET', url, true);
        xhr.responseType = "blob";
        xhr.onload = function (e) {
            const reader = new FileReader();
            reader.onload = function(event) {
                const res = event.target.result;
                resolve(res);
            }
            const file = this.response;
            reader.readAsDataURL(file);
        }
        xhr.send();
    });
}

let signaturePad = null;

window.addEventListener('load', async () => {

    const canvas = document.querySelector("canvas");
    canvas.height = canvas.offsetHeight;
    canvas.width = canvas.offsetWidth;

    signaturePad = new SignaturePad(canvas, {});

    const form = document.querySelector('#form');
    form.addEventListener('submit', (e) => {
        e.preventDefault();

        let curso = document.getElementById('curso').value;
        let nombres = document.getElementById('nombre').value;
        let apellidos = document.getElementById('apellido').value;
        let email = document.getElementById('email').value;
        let dni = document.getElementById('direccion').value;
        let telefono = document.getElementById('telefono').value;;
        
        

        generatePDF(curso, nombres, apellidos, email, dni, telefono);
    })

});

async function generatePDF(curso, nombres, apellidos, email, dni, telefono) {
    const image = await loadImage("formulario.jpg");
    const signatureImage = signaturePad.toDataURL();

    const pdf = new jsPDF('p', 'pt', 'letter');

    pdf.addImage(image, 'PNG', 0, 0, 565, 792);
    pdf.addImage(signatureImage, 'PNG', 200, 605, 300, 60);

    pdf.setFontSize(12);
    pdf.text(curso, 260, 125);

    const date = new Date();
    pdf.text(date.getUTCDate().toString(), 235, 150);
    pdf.text((date.getUTCMonth() + 1).toString(), 275, 150);
    pdf.text(date.getUTCFullYear().toString(), 320, 150);

    pdf.setFontSize(10);
    pdf.text(nombres, 170, 213);
    pdf.text(apellidos, 170, 200);
    pdf.text(dni, 170, 400);
    pdf.text(telefono, 170, 456);
    pdf.text(email, 170, 475);

    pdf.setFillColor(0,0,0);



    



    pdf.save("example.pdf");

}