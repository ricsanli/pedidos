<script>
const numero = 1234567.89;

// Formato para  Estados Unidos (miles con coma, decimales con punto)
const numeroFormateadoUS = numero.toLocaleString('en-US');
console.log(numeroFormateadoUS); // Salida: 1,234,567.89

// Formato para España (miles con punto, decimales con coma)
const numeroFormateadoES = numero.toLocaleString('es-ES');
console.log(numeroFormateadoES); // Salida: 1.234.567,89

// Formato para  México (miles con coma, decimales con punto)
const numeroFormateadoMX = numero.toLocaleString('es-MX');
console.log(numeroFormateadoMX); // Salida: 1,234,567.89

// Puedes especificar la cantidad de decimales deseada
const numeroFormateadoDecimales = numero.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
console.log(numeroFormateadoDecimales); // Salida: 1,234,567.89

// También puedes usarlo con Intl.NumberFormat para mayor control
const formatter = new Intl.NumberFormat('es-ES');
const numeroFormateadoIntl = formatter.format(numero);
console.log(numeroFormateadoIntl); // Salida: 1.234.567,89

// Para formatear como moneda, puedes usar style: 'currency' y currency: 'USD'
const numeroFormateadoMoneda = numero.toLocaleString('en-US', { style: 'currency', currency: 'USD' });
console.log(numeroFormateadoMoneda); // Salida: $1,234,567.89
</script>