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

            if(isset($_POST['pdf'])){
                // Obtener actividades seleccionadas del formulario
                $actividades_seleccionadas = $_POST['pdf'];

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

                // Mostrar contenido por cada actividad seleccionada
                foreach ($actividades_seleccionadas as $actividad_seleccionada) {
                    $pdf->AddPage();
                    $clases = $datos[$actividad_seleccionada] ?? array();

                    $pdf->SetFont('helvetica', 'B', 14);
                    $pdf->Cell(0, 10, 'Actividad: ' . $actividad_seleccionada, 0, 1);
                    // Mostrar tablas de alumnos inscritos por clase
                    foreach ($clases as $clase => $alumnos) {
                        $pdf->SetFont('helvetica', 'B', 12);
                        $pdf->Cell(0, 10, 'Clase: ' . $clase, 0, 1);

                        foreach ($alumnos as $alumno) {
                            // Excluir a los alumnos no inscritos
                            if (!empty($alumno)) {
                                $pdf->SetFont('helvetica', '', 10);
                                $pdf->Cell(0, 10, $alumno, 0, 1);
                            }
                        }
                    }
                }

                // Salida del PDF
                $pdf->Output('tabla_inscripciones.pdf', 'D');
            }
            else{
                $this->mensaje = 'Selecciona alguna actividad';
            }
            return $datos;
        }
    }