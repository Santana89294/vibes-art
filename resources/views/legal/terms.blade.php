<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vibes Art – Términos y Condiciones</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #0a0a0f;
            --surface: #12121a;
            --border: #1e1e2e;
            --a1: #c084fc;
            --a2: #f472b6;
            --text: #e2e2f0;
            --muted: #8a8aa8;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--bg);
            color: var(--text);
            padding: 2rem 1rem;
            line-height: 1.7;
        }

        .wrap {
            max-width: 760px;
            margin: 0 auto;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 2.5rem 2rem;
        }

        h1 {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            background: linear-gradient(135deg, var(--a1), var(--a2));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: .3rem;
        }

        .meta {
            color: var(--muted);
            font-size: .85rem;
            margin-bottom: 2rem;
        }

        h2 {
            font-size: 1.05rem;
            margin: 1.8rem 0 .5rem;
            color: var(--a1);
        }

        p,
        li {
            font-size: .92rem;
            color: #cfcfe6;
            margin-bottom: .6rem;
        }

        ul {
            padding-left: 1.3rem;
        }

        .alert {
            background: rgba(248, 113, 113, .1);
            border: 1px solid rgba(248, 113, 113, .35);
            border-radius: 12px;
            padding: 1rem 1.2rem;
            margin: 1rem 0;
        }

        .alert strong {
            color: #f87171;
        }

        a {
            color: var(--a1);
        }

        .back {
            display: inline-block;
            margin-bottom: 1.2rem;
            font-size: .85rem;
            text-decoration: none;
            color: var(--muted);
        }
    </style>
</head>

<body>
    <div class="wrap">
        <a href="javascript:history.back()" class="back">← Volver</a>
        <h1>Términos y Condiciones de Uso</h1>
        <div class="meta">Vibes Art · Versión 1.0 · Última actualización: {{ now()->locale('es')->isoFormat('D [de] MMMM [de] YYYY') }}</div>

        <div class="alert">
            <strong>Si estás en crisis o piensas en hacerte daño:</strong> Vibes Art no puede ayudarte en una emergencia.
            Llama ahora a la <strong>Línea 106</strong> (orientación en salud mental, gratuita, 24 horas) o a la
            <strong>Línea 123</strong> si hay un peligro inmediato. También puedes marcar a la
            <strong>Línea 192, opción 4</strong>.
        </div>

        <h2>1. Aceptación de los términos</h2>
        <p>Al crear una cuenta o usar Vibes Art (en adelante, "la Aplicación"), declaras que has leído, entendido y aceptado estos Términos y Condiciones. Si no estás de acuerdo con alguna parte, no debes registrarte ni usar la Aplicación.</p>

        <h2>2. Qué es Vibes Art</h2>
        <p>Vibes Art es una aplicación de <strong>bienestar emocional y expresión creativa</strong>, desarrollada con fines académicos por estudiantes de Ingeniería de Sistemas de la Universidad CESMAG. Permite escribir un diario personal, detecta de forma automática emociones a partir del texto y las transforma en obras de arte abstractas y música.</p>

        <h2>3. Lo que Vibes Art NO es</h2>
        <ul>
            <li>No es un servicio médico, psicológico, psiquiátrico ni terapéutico.</li>
            <li>No realiza diagnósticos ni evalúa trastornos mentales.</li>
            <li>No sustituye la consulta, el tratamiento ni el consejo de un profesional de la salud.</li>
            <li>No es un servicio de atención de emergencias ni de prevención del suicidio.</li>
        </ul>
        <p>La detección de emociones se basa en un análisis automático de palabras clave. Es <strong>aproximada, puede equivocarse</strong> y no refleja necesariamente tu estado emocional real. Los resultados tienen fines únicamente creativos y de autoconocimiento.</p>

        <h2>4. Uso bajo tu propia responsabilidad</h2>
        <p>El uso de la Aplicación es voluntario y bajo tu exclusiva responsabilidad. Las decisiones que tomes, las acciones que realices y las consecuencias que de ellas se deriven son tuyas. En la máxima medida permitida por la ley, los desarrolladores no serán responsables por daños, lesiones, perjuicios emocionales o de cualquier otra índole que se relacionen con el uso de la Aplicación, con la interpretación de sus resultados o con acciones tomadas por el usuario o por terceros.</p>
        <p>Si tienes un padecimiento de salud mental, o sospechas tenerlo, debes acudir a un profesional habilitado. No uses la Aplicación para tomar decisiones médicas o de salud.</p>

        <h2>5. Situaciones de riesgo y emergencia</h2>
        <p>La Aplicación <strong>no monitorea tus textos en tiempo real</strong> ni cuenta con personal que los revise, por lo que no puede detectar ni responder a situaciones de riesgo. Si tú o alguien más está en peligro, o tienes pensamientos de hacerte daño o de quitarte la vida, busca ayuda de inmediato:</p>
        <ul>
            <li><strong>Línea 106:</strong> orientación en salud mental, gratuita y confidencial, 24 horas.</li>
            <li><strong>Línea 123:</strong> número único de emergencias, cuando exista peligro inmediato.</li>
            <li><strong>Línea 192, opción 4:</strong> teleorientación en salud mental del Ministerio de Salud.</li>
            <li>Acude al servicio de urgencias más cercano o habla con una persona de confianza.</li>
        </ul>

        <h2>6. Requisitos para usar la Aplicación</h2>
        <p>Debes proporcionar información veraz y un correo electrónico válido, que será verificado. Eres responsable de la confidencialidad de tu contraseña y de toda actividad realizada desde tu cuenta. Si eres menor de edad, declaras contar con la autorización de tu madre, padre o representante legal para usar la Aplicación y para el tratamiento de tus datos.</p>

        <h2>7. Conducta del usuario</h2>
        <p>Te comprometes a no usar la Aplicación para actividades ilegales, para acosar o dañar a otras personas, ni para intentar vulnerar su seguridad o funcionamiento. Nos reservamos el derecho de suspender o bloquear cuentas que incumplan estos términos.</p>

        <h2>8. Tus textos y obras</h2>
        <p>Lo que escribes en tu diario es tuyo. Se almacena asociado a tu cuenta para generar tu galería, rachas y estadísticas. Los reportes del administrador se presentan de forma agregada y con fines de mejora del sistema. Las obras generadas son producto de un algoritmo; puedes usarlas libremente de forma personal.</p>

        <h2>9. Protección de datos personales</h2>
        <p>Tratamos tus datos (nombre, edad, correo electrónico y los textos que escribes) para prestarte el servicio, de acuerdo con la Ley 1581 de 2012 y demás normas colombianas sobre protección de datos personales. Tus textos pueden contener información sensible sobre tu estado emocional; por eso te recomendamos no incluir datos de terceros ni información que no quieras almacenar. Tienes derecho a conocer, actualizar, rectificar y solicitar la supresión de tus datos escribiendo a: <strong>[CORREO DE CONTACTO]</strong>. No vendemos ni cedemos tus datos a terceros con fines comerciales.</p>

        <h2>10. Disponibilidad y cambios en el servicio</h2>
        <p>La Aplicación se ofrece "tal cual" y "según disponibilidad", sin garantía de funcionamiento continuo o libre de errores. Podemos modificar, suspender o retirar funciones en cualquier momento. Servicios de terceros enlazados (como YouTube) se rigen por sus propios términos.</p>

        <h2>11. Modificaciones</h2>
        <p>Podemos actualizar estos términos. Cuando cambien de forma relevante, te lo informaremos y podremos pedirte que los aceptes nuevamente. El uso continuado de la Aplicación implica la aceptación de la versión vigente.</p>

        <h2>12. Ley aplicable</h2>
        <p>Estos términos se rigen por las leyes de la República de Colombia.</p>

        <h2>13. Contacto</h2>
        <p>Para dudas, solicitudes sobre tus datos o reportes: <a href="mailto:vibesart011@gmail.com"><strong>vibesart011@gmail.com</strong></a>.</p>
    </div>

</body>

</html>
