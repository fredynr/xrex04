<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\PatientEstudio;
use App\Models\Patient;
use App\Models\Exam;

class DatabaseSeeder extends Seeder
{
   /**
    * Seed the application's database.
    */
   public function run(): void
   {

      User::factory()->create([
         'name' => 'Alexander Fleming',
         'email' => 'test@example.com',
      ]);
      User::factory(10)->create();
      // Template::factory(100)->create();
      DB::table('templates')->insert([
         'title' => 'TORAX: HALLAZGO ASMA',
         'content' => 'Hiperinsuflación. Infiltrados parahiliares peribronquiales. Atelectasias lobares o segmentarias que se pueden malinterpretar como infección bacteriana. Signos de atelectasia, especialmente el desplazamiento cisural, mediastínico, hiliar y diafragmático hacia el pulmón atelectasiado.',
         'user_id' => '1',
         'created_at' => now()
      ]);
      DB::table('templates')->insert([
         'title' => 'TORAX: INFECCION VIRICA',
         'content' => 'Engrosamiento peribronquial, que da lugar a densidades lineales, de predominio en regiones parahiliares. Áreas focales de opacificación. Atelectasias cambiantes por tapones de moco. Áreas de atrapamiento aéreo.',
         'user_id' => '1',
         'created_at' => now()
      ]);
      DB::table('templates')->insert([
         'title' => 'TORAX: TRAUMA TORACICO',
         'content' => 'Masculino de 38 años, presenta traumatismo por aplastamiento. TC de tórax plano axial en ventana ósea (A, B) con fractura desplazada que comprometen a escapula izquierda , fracturas del 3er y 4to arco costal anterior izquierda',
         'user_id' => '1',
         'created_at' => now()
      ]);
      // pacientes
      DB::table('patients')->insert([
         'name' => 'Doe Augusta',
         'sexo' => 'F',
         'document' => '85123652',
         'type_document' => 'CC',
         'direction' => 'Calle 1 # 2-3',
         'phone' => '3001234567',
         'birth' => '1990-01-01',
         'email' => 'doe@mail.com'
      ]);
      DB::table('patients')->insert([
         'name' => 'Edwar Javier Calderon',
         'sexo' => 'M',
         'document' => '123496739',
         'type_document' => 'CC',
         'direction' => 'Carrera 202 #49-50',
         'phone' => '3009876543',
         'birth' => '1995-04-06',
         'email' => 'edwar@mail.com'
      ]);
      DB::table('patients')->insert([
         'name' => 'ELIXANDER GONZALEZ CARRASCAL',
         'sexo' => 'M',
         'document' => '88285222',
         'type_document' => 'CC',
         'direction' => 'Carrera 202 #49-50',
         'phone' => '3009876543',
         'birth' => '1978-11-09',
         'email' => 'elixander@mail.com'
      ]);

      DB::table('patients')->insert([
         'name' => 'ANA DIVA SALAZAR',
         'sexo' => 'F',
         'document' => '37321957',
         'type_document' => 'CC',
         'direction' => 'Carrera 202 #49-50',
         'phone' => '3009876543',
         'birth' => '1966-03-09',
         'email' => 'anadiva@mail.com'
      ]);
      DB::table('patients')->insert([
         'name' => 'TORCOROMA SANTOS',
         'sexo' => 'F',
         'document' => '37325081',
         'type_document' => 'CC',
         'direction' => 'Carrera 202 #49-50',
         'phone' => '3009876543',
         'birth' => '1972-08-15',
         'email' => 'torcoroma@mail.com'
      ]);


      Patient::factory(35)->create();

      //EPS
      DB::table('eps_senders')->insert([
         'name' => 'COOSALUD EPS',
         'code' => 'ESS024 ',
         'nit' => '900226715'
      ]);
      DB::table('eps_senders')->insert([
         'name' => 'NUEVA EPS',
         'code' => 'EPS037 ',
         'nit' => '900156264'
      ]);
      DB::table('eps_senders')->insert([
         'name' => 'FONDO DE PASIVO SOCIAL DE FERROCARRILES NACIONALES DE COLOMBIA',
         'code' => 'EAS027 ',
         'nit' => '800112806'
      ]);
      // lugares de salida
      DB::table('departure_places')->insert([
         'name' => 'EMERGENCIAS',
         'description' => 'Aenean justo risus, lacinia sed.'
      ]);
      DB::table('departure_places')->insert([
         'name' => 'HOSPITALIZACION GENERAL',
         'description' => 'Vestibulum ac turpis orci. Vestibulum.'
      ]);
      DB::table('departure_places')->insert([
         'name' => 'IMAGENES DIAGNOSTICAS',
         'description' => 'Nunc sodales lobortis ipsum viverra.'
      ]);
      DB::table('departure_places')->insert([
         'name' => 'TRAUMATOLOGIA',
         'description' => 'DCurabitur vitae convallis tellus. Nam.'
      ]);

      // examenes
      DB::table('exams')->insert([
         'remision' => 'RMDOE001',
         'patient_id' => 1,
         'eps_sender_id' => 1,
         'user_id' => 1,
         'departure_place_id' => 1,
         'exam_state' => 'Solicitado'
      ]);
      DB::table('exams')->insert([
         'remision' => 'RMDOE002',
         'patient_id' => 2,
         'eps_sender_id' => 2,
         'user_id' => 1,
         'departure_place_id' => 1,
         'exam_state' => 'Solicitado'
      ]);
      DB::table('exams')->insert([
         'remision' => 'RMDOE003',
         'patient_id' => 3,
         'eps_sender_id' => 3,
         'user_id' => 1,
         'departure_place_id' => 2,
         'exam_state' => 'Solicitado'
      ]);
      DB::table('exams')->insert([
         'remision' => 'RMDOE004',
         'patient_id' => 4,
         'eps_sender_id' => 3,
         'user_id' => 1,
         'departure_place_id' => 2,
         'exam_state' => 'Solicitado'
      ]);
      DB::table('exams')->insert([
         'remision' => 'RMDOE005',
         'patient_id' => 5,
         'eps_sender_id' => 3,
         'user_id' => 1,
         'departure_place_id' => 2,
         'exam_state' => 'Solicitado'
      ]);
      Exam::factory(16)->create();



      DB::table('patient_estudios')->insert([
         'study_name' => 'REQ/PAPERWORK',
         'tech_description' => 'Se observa alineación ósea conservada sin evidencia de desplazamiento o angulación anómala. La cortical ósea presenta integridad sin signos de fracturas, fisuras o lesiones líticas. Los espacios articulares de rodilla y tobillo mantienen su amplitud habitual sin signos de disminución o alteraciones degenerativas. No se identifican calcificaciones anómalas, cuerpos extraños ni signos de inflamación ósea. Los tejidos blandos adyacentes presentan densidad normal sin evidencia de edema o alteraciones patológicas.',
         'study_id_orthanc' => '1.3.6.1.4.1.5962.99.1.939772310.1977867020.1426868947350.494.0',
         'study_state' => 'Solicitado',
         'exam_id' => 1,
         'patient_id' => 1,
         'user_id' => 1,
         'priority' => 'Normal',
         'created_at' => now()
      ]);
      DB::table('patient_estudios')->insert([
         'study_name' => 'MR Abdomen with Gadolinium',
         'tech_description' => 'Se observa alineación ósea conservada sin desplazamientos anómalos. La estructura cortical mantiene su integridad sin evidencia de fracturas. Espacios articulares de apariencia normal, sin signos de estrechamiento o alteraciones degenerativas. No se identifican cuerpos extraños ni calcificaciones patológicas. Tejidos blandos sin anomalías visibles',
         'study_id_orthanc' => '1.3.6.1.4.1.5962.99.1.939772310.1977867020.1426868947350.4.0',
         'study_state' => 'Solicitado',
         'exam_id' => 1,
         'patient_id' => 1,
         'user_id' => 2,
         'priority' => 'Alta',
         'created_at' => now()
      ]);
      DB::table('patient_estudios')->insert([
         'study_name' => 'EXTREMIDADES SUPERIORES,EXTREMIDADES INFERIORES',
         'tech_description' => 'Se observa alineación ósea conservada sin desplazamientos anómalos. La estructura cortical mantiene su integridad sin evidencia de fracturas. Espacios articulares de apariencia normal, sin signos de estrechamiento o alteraciones degenerativas. No se identifican cuerpos extraños ni calcificaciones patológicas. Tejidos blandos sin anomalías visibles',
         'study_id_orthanc' => '1.3.51.0.7.13494092782.37088.64327.43383.33844.12644.6187',
         'study_state' => 'Solicitado',
         'exam_id' => 2,
         'patient_id' => 2,
         'user_id' => 2,
         'priority' => 'Normal',
         'created_at' => now()
      ]);


      PatientEstudio::factory(50)->create();
   }
}
