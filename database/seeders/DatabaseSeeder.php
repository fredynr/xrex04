<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\PatientEstudio;
use App\Models\Patient;
use App\Models\Exam;
use App\Models\Template;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
   /**
    * Seed the application's database.
    */
   public function run(): void
   {

      User::factory()->create([
         'name' => 'Eleuterio Atuesta',
         'email' => 'eleuterio@mail.com',
         'role' => 'Especialista',
      ]);
      User::factory()->create([
         'name' => 'David Atuesta',
         'email' => 'admin@sigandini.net',
         'role' => 'Tecnólogo',
      ]);
       User::factory()->create([
         'name' => 'Fredy Ruiz',
         'email' => 'fredy@mail.com',
         'role' => 'Transcriptor',
      ]);
       User::factory()->create([
         'name' => 'Cecilia Payne',
         'email' => 'cecilia@mail.com',
         'role' => 'Administrativo',
      ]);
      User::factory()->create([
         'name' => 'Nancy Roman',
         'email' => 'nancy@mail.com',
         'role' => 'Recepcionista',
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
         'name' => 'ANA DIVA SALAZAR',
         'sexo' => 'F',
         'document' => '37321957',
         'type_document' => 'CC',
         'direction' => 'Carrera 202 #49-50',
         'phone' => '3009876543',
         'birth' => '1966-03-09',
         'role' => 'Paciente',
         'email' => 'anadiva@mail.com',
         'password' => Hash::make('Xx123456'),
      ]);
      DB::table('patients')->insert([
         'name' => 'ANTONIO LUIS QUINTRO',
         'sexo' => 'M',
         'document' => '5453475',
         'type_document' => 'CC',
         'direction' => 'Carrera 202 #49-50',
         'phone' => '3009876543',
         'birth' => '1978-11-09',
         'role' => 'Paciente',
         'email' => 'antonio@mail.com',
         'password' => Hash::make('Xx123456'),
      ]);
      DB::table('patients')->insert([
         'name' => 'Edwar Javier Calderon',
         'sexo' => 'M',
         'document' => '123496739',
         'type_document' => 'CC',
         'direction' => 'Carrera 202 #49-50',
         'phone' => '3009876543',
         'birth' => '1995-04-06',
         'role' => 'Paciente',
         'email' => 'edwar@mail.com',
         'password' => Hash::make('Xx123456'),
      ]);
      DB::table('patients')->insert([
         'name' => 'CRISTIAN ALBERTO SOLANO',
         'sexo' => 'M',
         'document' => '1091664795',
         'type_document' => 'CC',
         'direction' => 'Carrera 202 #49-50',
         'phone' => '3009876543',
         'birth' => '1990-08-04',
         'role' => 'Paciente',
         'email' => 'cristian@mail.com',
         'password' => Hash::make('Xx123456'),
      ]);
      
      DB::table('patients')->insert([
         'name' => 'Doe Augusta',
         'sexo' => 'F',
         'document' => '85123652',
         'type_document' => 'CC',
         'direction' => 'Calle 1 # 2-3',
         'phone' => '3001234567',
         'birth' => '1990-01-01',
         'role' => 'Paciente',
         'email' => 'doe@mail.com',
         'password' => Hash::make('Xx123456'),
      ]);
      
      DB::table('patients')->insert([
         'name' => 'ELIXANDER GONZALEZ CARRASCAL',
         'sexo' => 'M',
         'document' => '88285222',
         'type_document' => 'CC',
         'direction' => 'Carrera 202 #49-50',
         'phone' => '3009876543',
         'birth' => '1978-11-09',
         'role' => 'Paciente',
         'email' => 'elixander@mail.com',
         'password' => Hash::make('Xx123456'),
      ]);
      DB::table('patients')->insert([
         'name' => 'JANETH CECILIA',
         'sexo' => 'F',
         'document' => '37366751',
         'type_document' => 'CC',
         'direction' => 'CLLE 10 #89-50',
         'phone' => '3009876543',
         'birth' => '1990-08-04',
         'role' => 'Paciente',
         'email' => 'janeth@mail.com',
         'password' => Hash::make('Xx123456'),
      ]);
      DB::table('patients')->insert([
         'name' => 'JERONIMO GALVIS',
         'sexo' => 'M',
         'document' => '1092184006',
         'type_document' => 'CC',
         'direction' => 'Transversal 02 #4-60',
         'phone' => '3009876543',
         'birth' => '2012-08-19',
         'role' => 'Paciente',
         'email' => 'jeronimo@mail.com',
         'password' => Hash::make('Xx123456'),
      ]);
      DB::table('patients')->insert([
         'name' => 'JUAN SEBASTIAN GARCIA',
         'sexo' => 'M',
         'document' => '1092185274',
         'type_document' => 'CC',
         'direction' => 'Barrio alto 56bis #00-50',
         'phone' => '3009876543',
         'birth' => '2013-12-14',
         'role' => 'Paciente',
         'email' => 'jsebastian@mail.com',
         'password' => Hash::make('Xx123456'),
      ]);
      DB::table('patients')->insert([
         'name' => 'KIARA SARAY DIAZ',
         'sexo' => 'F',
         'document' => '18904108',
         'type_document' => 'CC',
         'direction' => 'CALLE LA PERSEBERANCIA 82 #99-54',
         'phone' => '3009876543',
         'birth' => '2016-02-10',
         'role' => 'Paciente',
         'email' => 'kiara@mail.com',
         'password' => Hash::make('Xx123456'),
      ]);
      DB::table('patients')->insert([
         'name' => 'MATIAS JAIME MORALES',
         'sexo' => 'M',
         'document' => '1091670642',
         'type_document' => 'CC',
         'direction' => 'Barrio el peñol 98 #55-59',
         'phone' => '3009876543',
         'birth' => '2011-12-16',
         'role' => 'Paciente',
         'email' => 'matias@mail.com',
         'password' => Hash::make('Xx123456'),
      ]);
      
      DB::table('patients')->insert([
         'name' => 'TORCOROMA SANTOS',
         'sexo' => 'F',
         'document' => '37325081',
         'type_document' => 'CC',
         'direction' => 'Carrera 202 #49-50',
         'phone' => '3009876543',
         'birth' => '1972-08-15',
         'role' => 'Paciente',
         'email' => 'torcoroma@mail.com',
         'password' => Hash::make('Xx123456'),
      ]);
      DB::table('patients')->insert([
         'name' => 'DAVID TORRES',
         'sexo' => 'M',
         'document' => '1034285266',
         'type_document' => 'CC',
         'direction' => 'patio bonito 888 #87-77',
         'phone' => '3009876543',
         'birth' => '2000-01-01',
         'role' => 'Paciente',
         'email' => 'david@mail.com',
         'password' => Hash::make('Xx123456'),
      ]);

      DB::table('patients')->insert([
         'name' => 'PACIENTE SIN ESTUDIOS',
         'sexo' => 'M',
         'document' => '123456789',
         'type_document' => 'CC',
         'direction' => 'este paciente tiene un examen pero no tiene estudios',
         'phone' => '3001234567',
         'birth' => '2000-01-01',
         'role' => 'Paciente',
         'email' => 'nulo@mail.com',
         'password' => Hash::make('Xx123456'),
      ]);


      // Patient::factory(35)->create();

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
         'name' => 'FONDO DE PASIVO SOCIAL',
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
      DB::table('exams')->insert([
         'remision' => 'RMDOE006',
         'patient_id' => 6,
         'eps_sender_id' => 2,
         'user_id' => 1,
         'departure_place_id' => 1,
         'exam_state' => 'Realizado'
      ]);
      DB::table('exams')->insert([
         'remision' => 'RMDOE007',
         'patient_id' => 7,
         'eps_sender_id' => 1,
         'user_id' => 1,
         'departure_place_id' => 2,
         'exam_state' => 'Realizado'
      ]);
      DB::table('exams')->insert([
         'remision' => 'RMDOE008',
         'patient_id' => 8,
         'eps_sender_id' => 3,
         'user_id' => 1,
         'departure_place_id' => 3,
         'exam_state' => 'Realizado'
      ]);
      DB::table('exams')->insert([
         'remision' => 'RMDOE009',
         'patient_id' => 9,
         'eps_sender_id' => 2,
         'user_id' => 1,
         'departure_place_id' => 2,
         'exam_state' => 'Realizado'
      ]);
      DB::table('exams')->insert([
         'remision' => 'RMDOE0010',
         'patient_id' => 10,
         'eps_sender_id' => 2,
         'user_id' => 1,
         'departure_place_id' => 2,
         'exam_state' => 'Realizado'
      ]);
      DB::table('exams')->insert([
         'remision' => 'RMDOE0011',
         'patient_id' => 11,
         'eps_sender_id' => 2,
         'user_id' => 1,
         'departure_place_id' => 2,
         'exam_state' => 'Realizado'
      ]);
      DB::table('exams')->insert([
         'remision' => 'RMDOE0012',
         'patient_id' => 12,
         'eps_sender_id' => 2,
         'user_id' => 1,
         'departure_place_id' => 2,
         'exam_state' => 'Realizado'
      ]);
      DB::table('exams')->insert([
         'remision' => 'RMDOE0013',
         'patient_id' => 13,
         'eps_sender_id' => 2,
         'user_id' => 1,
         'departure_place_id' => 2,
         'exam_state' => 'Realizado'
      ]);

      DB::table('exams')->insert([
         'remision' => 'RMDOE0014',
         'patient_id' => 14,
         'eps_sender_id' => 2,
         'user_id' => 1,
         'departure_place_id' => 2,
         'exam_state' => 'Realizado'
      ]);
      // Exam::factory(500)->create();


      //1 ANA DIVA
      DB::table('patient_estudios')->insert([
         'study_name' => null,
         'tech_description' => null,
         'study_id_orthanc' => null,
         'study_state' => 'Solicitado',
         'exam_id' => 1,
         'patient_id' => 1,
         'user_id' => 2,
         'priority' => 'Normal',
         'created_at' => now()
      ]);
      // //2 ANTONIO LUIS QUINTRO
      DB::table('patient_estudios')->insert([
         'study_name' => null,
         'tech_description' => null,
         'study_id_orthanc' => null,
         'study_state' => 'Solicitado',
         'exam_id' => 2,
         'patient_id' => 2,
         'user_id' => 2,
         'priority' => 'Alta',
         'created_at' => now()
      ]);
      // //3 EDWAR JAVIER CALDERON
      DB::table('patient_estudios')->insert([
         'study_name' => null,
         'tech_description' => null,
         'study_id_orthanc' => null,
         'study_state' => 'Solicitado',
         'exam_id' => 3,
         'patient_id' => 3,
         'user_id' => 2,
         'priority' => 'Normal',
         'created_at' => now()
      ]);
      // //4 CRISTIAN ALBERTO SOLANO
      DB::table('patient_estudios')->insert([
         'study_name' => null,
         'tech_description' => null,
         'study_id_orthanc' => null,
         'study_state' => 'Solicitado',
         'exam_id' => 4,
         'patient_id' => 4,
         'user_id' => 2,
         'priority' => 'Normal',
         'created_at' => now()
      ]);
      // //5 DOE
      DB::table('patient_estudios')->insert([
         'study_name' => null,
         'tech_description' => null,
         'study_id_orthanc' => null,
         'study_state' => 'Solicitado',
         'exam_id' => 5,
         'patient_id' => 5,
         'user_id' => 2,
         'priority' => 'Normal',
         'created_at' => now()
      ]);
      // // 5 DOE
      DB::table('patient_estudios')->insert([
         'study_name' => null,
         'tech_description' => null,
         'study_id_orthanc' => null,
         'study_state' => 'Solicitado',
         'exam_id' => 5,
         'patient_id' => 5,
         'user_id' => 2,
         'priority' => 'Normal',
         'created_at' => now()
      ]);

      //desde aquí para el especialista
      // // 6 ELIXANDER GONZALEZ CARRASCAL
      DB::table('patient_estudios')->insert([
         'study_name' => 'PELVIS, COL.LUMBAR',
         'tech_description' => 'Se observa alineación ósea conservada sin desplazamientos anómalos. La estructura cortical mantiene su integridad sin evidencia de fracturas. Espacios articulares de apariencia normal, sin signos de estrechamiento o alteraciones degenerativas. No se identifican cuerpos extraños ni calcificaciones patológicas. Tejidos blandos sin anomalías visibles',
         'study_id_orthanc' => '70e6be7f-0a3781ec-59d1bfd9-1b32fc31-7598d857',
         'study_state' => 'Realizado',
         'exam_id' => 6,
         'patient_id' => 6,
         'user_id' => 2,
         'priority' => 'Alta',
         'created_at' => now()
      ]);
      // // 7 JANETH CECILIA
      DB::table('patient_estudios')->insert([
         'study_name' => 'UNKNOWN',
         'tech_description' => 'Se observa alineación ósea conservada sin desplazamientos anómalos. La estructura cortical mantiene su integridad sin evidencia de fracturas. Espacios articulares de apariencia normal, sin signos de estrechamiento o alteraciones degenerativas. No se identifican cuerpos extraños ni calcificaciones patológicas. Tejidos blandos sin anomalías visibles',
         'study_id_orthanc' => '4fdfa9a2-2304a3ff-886914ea-fa465acf-00e5abea',
         'study_state' => 'Realizado',
         'exam_id' => 7,
         'patient_id' => 7,
         'user_id' => 2,
         'priority' => 'Alta',
         'created_at' => now()
      ]);
      // // 8 JERONIMO GALVIS
      DB::table('patient_estudios')->insert([
         'study_name' => 'UP_EXM, MANO',
         'tech_description' => 'Se observa alineación ósea conservada sin desplazamientos anómalos. La estructura cortical mantiene su integridad sin evidencia de fracturas. Espacios articulares de apariencia normal, sin signos de estrechamiento o alteraciones degenerativas. No se identifican cuerpos extraños ni calcificaciones patológicas. Tejidos blandos sin anomalías visibles',
         'study_id_orthanc' => 'd0c79d2b-c84f54da-a7753954-ab2d2586-52bd73bc',
         'study_state' => 'Realizado',
         'exam_id' => 8,
         'patient_id' => 8,
         'user_id' => 2,
         'priority' => 'Baja',
         'created_at' => now()
      ]);
      // // 9 JUAN SEBASTIAN GARCIA
      DB::table('patient_estudios')->insert([
         'study_name' => 'CHEST, CLAVICULA',
         'tech_description' => 'Se observa alineación ósea conservada sin desplazamientos anómalos. La estructura cortical mantiene su integridad sin evidencia de fracturas. Espacios articulares de apariencia normal, sin signos de estrechamiento o alteraciones degenerativas. No se identifican cuerpos extraños ni calcificaciones patológicas. Tejidos blandos sin anomalías visibles',
         'study_id_orthanc' => '6ecfab12-82c7e46c-1b4d31d0-ac65e078-e78045b1',
         'study_state' => 'Realizado',
         'exam_id' => 9,
         'patient_id' => 9,
         'user_id' => 2,
         'priority' => 'Alta',
         'created_at' => now()
      ]);
      // // 10 KIARA SARAY DIAZ
      DB::table('patient_estudios')->insert([
         'study_name' => 'HEAD, CRANEO,LAT',
         'tech_description' => 'Se observa alineación ósea conservada sin desplazamientos anómalos. La estructura cortical mantiene su integridad sin evidencia de fracturas. Espacios articulares de apariencia normal, sin signos de estrechamiento o alteraciones degenerativas. No se identifican cuerpos extraños ni calcificaciones patológicas. Tejidos blandos sin anomalías visibles',
         'study_id_orthanc' => 'c5b9cdc3-1795d2f2-1df51083-4b1c7113-23bae46d',
         'study_state' => 'Realizado',
         'exam_id' => 10,
         'patient_id' => 10,
         'user_id' => 2,
         'priority' => 'Alta',
         'created_at' => now()
      ]);
      // //11 MATIAS JAIME MORALES
      DB::table('patient_estudios')->insert([
         'study_name' => 'UP_EXM, CODO, FRN',
         'tech_description' => 'Se observa alineación ósea conservada sin desplazamientos anómalos. La estructura cortical mantiene su integridad sin evidencia de fracturas. Espacios articulares de apariencia normal, sin signos de estrechamiento o alteraciones degenerativas. No se identifican cuerpos extraños ni calcificaciones patológicas. Tejidos blandos sin anomalías visibles',
         'study_id_orthanc' => '08ea8510-4034bc84-a088350e-3bec6e03-ff9b7766',
         'study_state' => 'Realizado',
         'exam_id' => 11,
         'patient_id' => 11,
         'user_id' => 2,
         'priority' => 'Alta',
         'created_at' => now()
      ]);
      // //12 TORCOROMA SANTOS
      DB::table('patient_estudios')->insert([
         'study_name' => 'PELVIS, COL.LUMBAR',
         'tech_description' => 'Se observa alineación ósea conservada sin desplazamientos anómalos. La estructura cortical mantiene su integridad sin evidencia de fracturas. Espacios articulares de apariencia normal, sin signos de estrechamiento o alteraciones degenerativas. No se identifican cuerpos extraños ni calcificaciones patológicas. Tejidos blandos sin anomalías visibles',
         'study_id_orthanc' => 'f9464959-ba00192f-289c26ed-d9d77596-68936617',
         'study_state' => 'Realizado',
         'exam_id' => 12,
         'patient_id' => 12,
         'user_id' => 2,
         'priority' => 'Alta',
         'created_at' => now()
      ]);
      // //13 DAVID TORRES
      DB::table('patient_estudios')->insert([
         'study_name' => 'UNKNOWN',
         'tech_description' => 'Se observa alineación ósea conservada sin desplazamientos anómalos. La estructura cortical mantiene su integridad sin evidencia de fracturas. Espacios articulares de apariencia normal, sin signos de estrechamiento o alteraciones degenerativas. No se identifican cuerpos extraños ni calcificaciones patológicas. Tejidos blandos sin anomalías visibles',
         'study_id_orthanc' => '85516dea-f7759362-7f201f9a-b42fdc2c-fa46894d',
         'study_state' => 'Realizado',
         'exam_id' => 13,
         'patient_id' => 13,
         'user_id' => 2,
         'priority' => 'Alta',
         'created_at' => now()
      ]);
      PatientEstudio::factory(1000)->create();
   }
}
