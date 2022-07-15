/*
funciones de javascript para comprobar formularios
creadas por: Duilio Palacios
e-mail: solo@otrotiempo.com
Licencia: CreativeCommons
*/
function validar(formulario,mandar) {
	var campos  = formulario.getElementsByTagName("input");
	var listaErrores = document.getElementById("lista-errores");
	limpiarNodo(listaErrores);
	modificado = esModificado();
	longitud = campos.length;	

	for (i=0; i<longitud; i++) {
		var campo = new clsCampo( campos.item(i) );

		if( campo.type == "text" )
			if ( !( campo.esObligatorio() && campo.vacio() ) ) {					
			  switch ( campo.tipo ) {
				case 't': campo.soloTexto(); break;
				case 'n': campo.natural(); break;
				case 'z': campo.entero(); break;
				case 'q': campo.realPositivo(); break;
				case 'r': campo.numeroReal(); break;
				case 'e': campo.correo(); break;
			  }
			}
		else if ( ( campo.type == "file" ) || ( campo.type == "password" ) )
			if ( !modificado && campo.esObligatorio() ) campo.vacio();
		if ( campo.error )
		  listaErrores.appendChild( crearLI( campo.error ) );
	}
	campos = formulario.getElementsByTagName("textarea");
	longitud = campos.length;
	for (i=0; i<longitud; i++) {
		var campo = new clsCampo( campos.item(i) );
		if ( campo.esObligatorio() && campo.vacio() )
		  listaErrores.appendChild( crearLI( campo.error ) );
	}
	campos = formulario.getElementsByTagName("select");
	longitud = campos.length;
	for (i=0; i<longitud; i++) {
		var campo = new clsCampo( campos.item(i) );
		if ( campo.esObligatorio() && !campo.estaSeleccionado() )
		  listaErrores.appendChild( crearLI( campo.error ) );
	}
	formValido = !listaErrores.getElementsByTagName("li").length;
	if ( formValido && mandar ) enviar(formulario);
	
	return formValido;
}
/***/
function clsCampo (campo) {
	this.campo = campo;
//	this.campo.value = campo.value;
	this.type = this.campo.getAttribute("type");
	this.tipo = this.campo.name.charAt(0).toLowerCase();
	this.error = false;
}
clsCampo.prototype.esObligatorio = function esObligatorio() {
	var chr = this.campo.name.charAt(0);
	if ( chr.search('[A-Z]') || (chr == 'W') ) return false;
	return true;
}
clsCampo.prototype.vacio = function vacio() {
	valor = trim(this.campo.value);
	if ( valor.length!=0 ) return false;
	this.error = 'Debe completar el campo "'+this.formatoNombre()+'"';
	return true;
}
clsCampo.prototype.natural = function natural() {
	if( this.campo.value.search('[^0-9]') == -1 ) return true;
	this.error = 'el campo "'+this.formatoNombre()+'" solo puede tener numeros enteros sin signo';
	return false;
}
clsCampo.prototype.entero = function entero() {
	if( this.campo.value.search('^-?[0-9]+$') != -1 ) return true;
	this.error = 'el campo "'+this.formatoNombre()+'" solo puede tener numeros enteros';
	return false;
}
clsCampo.prototype.realPositivo = function realPositivo() {
	if( this.campo.value.search('[^0-9.]') == -1 ) return true;
	this.error = 'el campo "'+this.formatoNombre()+'" solo puede tener numeros sin signo';					 
	return false;
}
clsCampo.prototype.numeroReal = function numeroReal() {
	if( this.campo.value.search('[^0-9.-]') == -1 ) return true;
	this.error = 'el campo "'+this.formatoNombre()+'" solo puede tener numeros';
	return false;
}
clsCampo.prototype.soloTexto = function soloTexto() {
	if( this.campo.value.search('^[a-z A-Z]+$') != -1 ) return true;
	this.error = 'el campo "'+this.formatoNombre()+'" solo puede tener texto';
	return false;
}
clsCampo.prototype.correo = function correo() {
	if( this.campo.value.toLowerCase().search('(^[a-z][a-z0-9\-_.]+[@][a-z0-9\-_.]+[.][a-z]+$)') != -1 ) return true;
	this.error = 'el campo "'+this.formatoNombre()+'" debe ser un correo valido';
	return false;
} 
clsCampo.prototype.estaSeleccionado = function estaSeleccionado() {
	var valor = parseInt(this.campo.options[this.campo.selectedIndex].value);
	if ( isNaN(valor) || valor ) return true;
	this.error =  'debe eligir un valor del combo "'+this.formatoNombre()+'"';
	return false;
}
/***/
clsCampo.prototype.formatoNombre = function formatoNombre() {
	nombre = this.campo.name;
	return nombre.charAt(1).toUpperCase()+nombre.replace(/_/g,' ').substr(2);
}
function enviar(formulario) {	
//	formulario.boton.setAttribute('disabled','disabled');
	formulario.submit();
}
function esModificado() {
	if ( parseInt( document.getElementById('id').value ) ) return true;
	else return false;
}
function trim(str) {
	return str.replace(/^\s*|\s*$/g,"");
}
/* DOM */
function crearLI(txt){
	var objLI = document.createElement('li');
	objLI.appendChild( document.createTextNode( txt ) );
	return objLI;
}
function limpiarNodo(nodo){
	while( nodo.hasChildNodes() ) nodo.removeChild(nodo.firstChild);
}