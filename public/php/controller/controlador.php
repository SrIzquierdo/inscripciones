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
        public function vistaInscripciones(){
            $this->vista = 'vistaTablaInscripciones';
            $datos = $this->Modelo->tabla_inscripciones();
            return $datos;
        }

        public function generarPDF(){
            $this->vista = 'vistaTablaInscripciones';
            $datos = $this->Modelo->tabla_inscripciones();
            if(isset($_POST['actividad'])){
                // Obtener actividades seleccionadas del formulario
                $actividades_seleccionadas = $_POST['actividad'];

                // Obtener los datos de la base de datos
                $datos = $this->Modelo->tabla_inscripciones();

                // Crear instancia de TCPDF
                $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

                // Establecer información del documento
                $pdf->SetCreator(PDF_CREATOR);
                $pdf->SetAuthor('Autor');
                $pdf->SetTitle('Tabla de Inscripciones');
                $pdf->SetSubject('Tabla de Inscripciones');
                $pdf->SetKeywords('PDF, tabla, inscripciones');

                // Variable para almacenar la última actividad procesada
                $ultima_actividad = '';

                // Mostrar contenido por cada actividad seleccionada
                foreach ($actividades_seleccionadas as $actividad_seleccionada) {
                    $clases = $datos[$actividad_seleccionada] ?? array();

                    // Verificar si la actividad ha cambiado para crear una nueva página
                    if ($actividad_seleccionada != $ultima_actividad) {
                        $pdf->AddPage();
                        $pdf->SetFont('helvetica', 'B', 14);
                        $pdf->Cell(0, 10, 'Actividad: ' . $actividad_seleccionada, 0, 1);
                        $ultima_actividad = $actividad_seleccionada;
                    }

                    // Mostrar tabla de alumnos inscritos por clase
                    $pdf->SetFont('helvetica', '', 12);
                    $html = '<table border="1" cellpadding="4">
                                <thead>
                                    <tr style="background-color: #3498db; font-weight: bolder; text-align: center; color: #ffffff; font-size: 14px">
                                        <th>Alumno</th>
                                        <th>Clase</th>
                                    </tr>
                                </thead>
                                <tbody>';

                    foreach ($clases as $clase => $alumnos) {
                        foreach ($alumnos as $alumno) {
                            // Excluir a los alumnos no inscritos
                            if (!empty($alumno)) {
                                $html .= '<tr><td>' . $alumno . '</td><td>' . $clase . '</td></tr>';
                            }
                        }
                    }

                    $html .= '</tbody></table>';
                    $pdf->writeHTML($html, true, false, false, false, '');
                }

                // Salida del PDF
                $pdf->Output('tabla_inscripciones.pdf', 'D');
            }
            else{
                $this->vista = 'vistaFormularioPDF';
                $this->mensaje = 'Selecciona alguna actividad';
                return $this->Modelo->tabla_actividad();
            }
            return $datos;
        }

        public function vistaDescargarPDF(){
            $this->vista = 'vistaFormularioPDF';
            return $this->Modelo->tabla_actividad();
        }
    }