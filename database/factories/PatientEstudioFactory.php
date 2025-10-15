<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as FakerFactory;
use App\Models\Exam;
use App\Models\Patient;
use App\Models\EpsSender;
use App\Models\User;
use Carbon\Carbon;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PatientEstudio>
 */
class PatientEstudioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Fecha entre el 1 y el 8 del mes actual
        $date_realized = Carbon::create(
            now()->year,
            now()->month,
            rand(1, 8),
            rand(0, 23),
            rand(0, 59),
            rand(0, 59)
        );

        // Fecha entre el 9 y el 15 del mes actual
        $date_transcriber = Carbon::create(
            now()->year,
            now()->month,
            rand(9, 15),
            rand(0, 23),
            rand(0, 59),
            rand(0, 59)
        );

        // Fecha entre el 16 y el 30 del mes actual
        $date_finalized = Carbon::create(
            now()->year,
            now()->month,
            rand(16, 30),
            rand(0, 23),
            rand(0, 59),
            rand(0, 59)
        );


        $faker = FakerFactory::create();
        return [
            'study_name' => $faker->randomElement([
                'RADIOGRAFIA DE CRANEO SIMPLE',
                'RADIOGRAFIA DE BASE DE CRANEO',
                'RADIOGRAFIA DE SILLA TURCA',
                'RADIOGRAFIA DE MASTOIDES COMPARATIVAS',
                'RADIOGRAFIA DE PEÑASCOS',
                'RADIOGRAFIA DE CONDUCTO AUDITIVO INTERNO',
                'RADIOGRAFIA DE CARA (PERFILOGRAMA) +',
                'RADIOGRAFIA DE ORBITAS',
                'RADIOGRAFIA DE AGUJEROS  OPTICOS',
                'RADIOGRAFIA DE MALAR',
                'RADIOGRAFIA DE ARCO CIGOMATICO',
                'RADIOGRAFIA DE HUESOS NASALES',
                'RADIOGRAFIA DE SENOS PARANASALES',
                'RADIOGRAFIA DE MAXILIAR SUPERIOR',
                'RADIOGRAFIA DE MAXILIAR INFERIOR',
                'RADIOGRAFIA DE  ARTICULACION TEMPOROMAXILAR (ATM)',
                'RADIOGRAFIA DE TEJIDOS BLANDOS DEL CUELLO',
                'RADIOGRAFIA DE CAVUM FARINGEO',
                'RADIOGRAFIA DE FARINGE (FARINGOGRAFIA) +',
                'RADIOGRAFIA DE COLUMNA CERVICAL',
                'RADIOGRAFIA DE COLUMNA CERVICO- DORSAL',
                'RADIOGRAFIA DE COLUMNA TORACICA',
                'RADIOGRAGIA DE COLUMNA DORSOLUMBAR',
                'RADIOGRAFIA DE COLUMNA LUMBOSACRA',
                'TEST DE ESCOLIOSIS',
                'RADIOGRAFIA DE SACRO COCCIX',
                'RADIOGRAFIA DE COLUMNA VERTEBRAL TOTAL',
                'RADIOGRAFIA DINAMICA DE DE COLUMNA VERTEBRAL',
                'RADIOGRAFIA DE ARTICULACIONES SACROILIACAS',
                'RADIOGRAFIA DE REJA  COSTAL',
                'RADIOGRAFIA DE ESTERNON',
                'RADIOGRAFIA DE TORAX (P.A o A.P y lateral, de cubito lateral, oblicuas o lateral con bario)',
                'RADIOGRAFIA DE ARTICULACIONES ESTERNOCLAVICULARES',
                'RADIOGRAFIA DE ABDOMEN SIMPLE',
                'RADIOGRAFIA DE HUESOS LARGOS SERIE COMPLETA (esqueleto axial y apendipular)',
                'RADIOGRAFIA PARA DETECTAR EDAD OSEA (CARPOGRAMA)+',
                'RADIOGRAFIA DE OMOPLATO',
                'RADIOGRAFIA DE CLAVICULA',
                'RADIOGRAFIA DE HUMERO',
                'RADIOGRAFIA DE ANTEBRAZO',
                'RADIOGRAFIA DE ARTICULACIONES ACROMIO CLAVICULARES COMPARATIVAS',
                'RADIOGRAFIA DE HOMBRO',
                'RADIOGRAFIA DE CODO',
                'RADIOGRAFIA DE MUÑECA+',
                'RADIOGRAFIA DE DEDOS EN MANO+',
                'RADIOGRAFIA DE MEDICION DE MIEMBROS INFERIORES (estudio de farril u osteometria). Estudio de pie plano (pies con apoyo)',
                'RADIOGRAFIA DE ANTEVERSION FEMORAL',
                'RADIOGRAFIA DE FEMUR AP Y LATERAL',
                'RADIOGRAFIA DE PIERNA AP Y LATERAL',
                'RADIOGRAFIA DE ANTEVERSION TIBIAL',
                'RADIOGRAFIA DE PIE AP Y LATERAL',
                'RADIOGRAFIA DE CALCANEO AXIAL Y LATERAL',
                'RADIOGRAFIA DE MIEMBROS INFERIOR AP Y LATERAL',
                'RADIOGRAFIA DE CADERA O ARTICULACION COXO - FEMORAL (AP LATERAL)+',
                'RADIOGRAFIA DE CADERA COMPARATIVA',
                'RADIOGRAFIA DE PELVIS O ARTICULACIONES COXOFEMORAL',
                'RADIOGRAFIA DE RODILLA AP, LATERAL',
                'RADIOGRAFIA DE RODILLA COMPARATIVA POSICION VERTICAL(unicamente vista anteroposterior)',
                'RADIOGRAFIA TANGENCIAL DE ROTULA',
                'RADIOGRAFIA AXIALES DE ROTULA O LONGITUD DE MIEMBROS INFERIORES',
                'RADIOGRAFIA DE TOBILLO AP Y LATERAL Y ROTACION INTERNA',
                'RADIOGRAFIA DE ANTEPIE AP Y OBLICUA',
                'RADIOGRAFIA COMPARATIVAS DE EXTREMIDADES INFERIORES',
                'RADIOGRAFIA EN EXTREMIDADES PROYECCIONES ADICIONALES: stress, tunel, oblicuas'
            ]),
            // 'tech_description' => $faker->paragraph(),
            'tech_description' => $faker->randomElement([
                'Paciente refiere dolor agudo en el área examinada desde hace 3 días',
                'Se observó dificultad para mantener la posición durante el estudio',
                'Estudio realizado sin contraste, según indicación médica.',
                'Paciente con antecedentes de cirugía en la zona examinada.',
                'Artefacto por movimiento presente en algunas imágenes.',
                'Paciente embarazada, se tomaron precauciones adicionales.',
                'Se utilizó protocolo pediátrico por edad del paciente.',
                'Paciente con marcapasos, se evitó resonancia magnética.',
                'Estudio incompleto por intolerancia del paciente al procedimiento.',
                'Se repitió la serie axial por artefacto de respiración.',
                'Sospecha de fractura en extremidad izquierda tras caída.',
                'Paciente con yeso, se limitó el rango de proyección.',
                'Proyección lateral no óptima por dolor del paciente.',
                'Estudio con contraste oral y endovenoso. Tiempo de espera respetado.',
                'Paciente con antecedentes de trauma craneoencefálico.',
                'Se observó masa hipodensa en región hepática, a confirmar',
                'Estudio de columna lumbar por lumbalgia crónica.',
                'Paciente refiere parestesias en miembros inferiores.',
                'Secuencia T2 con artefacto por movimiento involuntario.',
                'Paciente refiere nódulo palpable en cuadrante superior externo.',
                'Estudio de control post-biopsia realizado según protocolo.'
            ]),
            'reading' => $faker->paragraph(),
            'specialist_user_id' => User::where('role', 'Especialista')->inRandomOrder()->first()->id,
            'transcriber_user_id' => User::where('role', 'Transcriptor')->inRandomOrder()->first()->id,
            'study_state' => 'Finalizado',
            'exam_id' => Exam::inRandomOrder()->first()->id,
            'patient_id' => Patient::inRandomOrder()->first()->id,
            'date_realized' => $date_realized,
            'date_transcriber' => $date_transcriber,
            'date_finalized' => $date_finalized,
            'user_id' => User::inRandomOrder()->first()->id,
            'priority' => $faker->randomElement(['Baja', 'Normal', 'Alta']),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
