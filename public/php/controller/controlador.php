<?php
    require_once 'php/config/config.php';
    require_once 'php/model/modelo.php';
    require_once 'TCPDF-main/tcpdf.php';

    class Controlador{
        protected $Modelo;
        public $vista;
        public $mensaje;
        /**
         * Contructor de la clase Controlador, instancia un objeto de la clase Modelo.
         */
        function __construct(){
            $this->Modelo = new Modelo();
        }
        /**
         * Método por defecto, Comprueba que existe una cookie de recordar la sesión.
         */
        public function porDefecto(){
            $this->vista = 'vistaTablaInscripciones';
            $datos = $this->Modelo->tabla_inscripciones();
            return $datos;
        }

        public function generarPDF(){
            $this->vista = 'vistaTablaInscripciones';
            $datos = $this->Modelo->tabla_inscripciones();

            $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('Aarón Izquierdo');
            $pdf->SetTitle('Inscripciones');
            $pdf->SetSubject('Fiestas Escolares');
            $pdf->SetKeywords('');

            // Establecer el encabezado y pie de página
            $pdf->SetHeaderData('', 15, '', '', array(0,64,255), array(0,64,128));
            $pdf->setFooterData(array(0,64,0), array(0,64,128));

            // Establecer márgenes
            $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
            $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
            $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

            // Establecer el modo de subconjunto de fuentes

            // Agregar una página
            $pdf->AddPage();
            $html = '<style>
            * {
                margin: 0;
                padding: 0;
            }  
            body {
                font-family: Arial, sans-serif;
                background-color: #f4f4f4;
            }
            main{
                width: 800px;
                padding: 20px;
                margin: 0 auto 20px;
                background-color: #fff;
                border-radius: 8px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            }
            header {
                background-color: #3498db;
                padding: 20px;
                margin-bottom: 40px;
                display: flex;
                justify-content: space-between;
                align-items: center;
            }
            .cabeceraIzquierda {
                display: flex;
                align-items: center;
            }
            .cabeceraIzquierda h1 {
                color: #fff;
                font-size: 32px;
                font-weight: bold;
                margin: 0; /* Elimina cualquier margen adicional */
            }
            .cabeceraDerecha {
                display: flex;
                align-items: center;
            }
            nav {
                display: flex;
            }
            nav a {
                color: #fff;
                text-decoration: none;
                background-color: #2ecc71;
                padding: 8px 12px;
                border-radius: 4px;
                margin-right: 10px;
                transition: background-color 0.3s ease;
            }
            nav a:last-child {
                margin-right: 0;
            }
            nav a:hover {
                background-color: #27ae60;
            }
            h1 {
                color: #333;
                margin-bottom: 20px;
                text-align: center;
            }
            h2 {
                color: #333;
                margin-bottom: 10px;
            }
            h2.mensaje{
                color: #4d4d4d;
                text-align: center;
            }
            p {
                margin-bottom: 20px;
            }
            table {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 20px;
            }
            table th, table td {
                border: 1px solid #ddd;
                padding: 8px;
                text-align: left;
            }
            table tr:nth-child(odd){
                background-color: #f2f2f2;
            }
            table th {
                background-color: #3498db;
                color: #fff;
                border-color: #3498db;
            }</style>';
            $clases = array();
            foreach ($datos as $fila) {
                $clase = $fila['clase'];
                if (!isset($clases[$clase])) {
                    $clases[$clase] = array();
                }
                $clases[$clase][] = $fila;
            }
            foreach ($clases as $clase => $alumnosClase) {
                $html .= "<main><h1>Clase: $clase</h1>";
                // Separar alumnos inscritos de los no inscritos
                $actividades = array();
                $no_inscritos = array();
        
                foreach ($alumnosClase as $fila) {
                    if ($fila['actividad']) {
                        $actividades[$fila['actividad']][] = $fila['alumno'];
                    } else {
                        $no_inscritos[] = $fila['alumno'];
                    }
                }
        
                // Mostrar tablas de alumnos inscritos por actividad
                foreach ($actividades as $actividad => $alumnos) {
                    $html .= "<table><caption><h3>$actividad</h3></caption>";
                        foreach ($alumnos as $alumno) {
                            $html .= "<tr><td>$alumno</td></tr>";
                        }
                    $html .= '</table>';
                }
                // Mostrar tabla de alumnos no inscritos
                $html .= '<table><caption><h3>No Inscritos</h3></caption>';
                foreach ($no_inscritos as $alumno) {
                    $html .= "<tr><td>$alumno</td></tr>";
                }
                $html .= '</table></main>';
            }
            // Escribir texto
            $pdf->SetFont('helvetica', 'B', 12);
            $pdf->writeHTML($html, true, false, true, false, '');

            // Salida del PDF
            $pdf->Output('Inscripciones.pdf', 'D');

            return $datos;
        }
    }