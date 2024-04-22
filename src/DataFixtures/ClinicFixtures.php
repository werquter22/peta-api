<?php

namespace App\DataFixtures;

use App\Component\Category\CategoryFactory;
use App\Component\Clinic\ClinicFactory;
use App\Component\Employee\EmployeeFactory;
use App\Component\Service\ServiceFactory;
use App\Component\User\UserFactory;
use App\Entity\MediaObject;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ClinicFixtures extends Fixture
{
    private array $categories = [
        [
            'name' => 'Dental clinics',
            'description' => 'Dental clinics offer a full range of services to take care of your smile. From professional hygiene and caries treatment to orthodontics and implantation, we will ensure your teeth are healthy and beautiful.',
        ],
        [   "name" => 'Oncology clinics',
            'description' => 'Oncology clinics employ oncologists who specialize in the diagnosis, treatment and rehabilitation of patients with cancer. We provide personalized attention and advanced treatment methods to achieve the best results.',
        ],
        [
            "name" => 'Therapy clinics',
            'description' => 'Therapy clinics offer a wide range of medical services, including diagnosis and treatment of various diseases. Our therapists will provide you with quality medical care and care for your health.',
        ],
        [
            "name" => 'Trauma clinics',
            'description' => 'Trauma clinics employ specialists in the treatment of trauma and orthopedic diseases. We offer a comprehensive approach to the treatment of injuries, rehabilitation and restoration of functions of the musculoskeletal system.',
        ],
        [
            "name" => 'Surgical clinics',
            'description' => 'Surgical clinics provide services for planned and emergency operations of various types. Our highly trained surgeons will provide you with safe and effective surgical care.',
        ],
        [
            "name" => 'Laboratory testing clinics',
            'description' => 'Laboratory testing clinics offer a wide range of laboratory tests for the diagnosis of various diseases. We use advanced technologies and techniques for accurate and fast diagnosis.',
        ],
        [
            "name" => 'Endoscopy clinics',
            'description' => 'Endoscopic clinics specialize in the diagnosis and treatment of diseases using endoscopic methods. Our specialists will perform procedures with maximum comfort and minimal risks for the patient.',
        ],
        [
            "name" => 'Infectious diseases clinics',
            'description' => 'Infectious diseases clinics specialize in the diagnosis, treatment and prevention of infectious diseases. Our doctors will provide you with competent care and recommendations to prevent infections.',
        ],
        [
            "name" => 'Vaccination clinics',
            'description' => 'Vaccination clinics offer a wide range of vaccines to prevent various infectious diseases. We guarantee high-quality vaccines and professional administration, taking into account all medical standards.',
        ],
    ];

    private array $services = [
        [
            'name' => 'General doctor',
        ],
        [
            'name' => 'Surgeon',
        ],
        [
            'name' => 'Therapist',
        ]
    ];
    private array $clinics = [
        [
            'name' => 'Doctor & Animal',
            'phone' => '(998) 71-268-40-26',
            'address' => 'Uzbekistan, Tashkent, MIRZO-ULUGBEK DISTRICT, ave. MIRZO ULUGBEK, 40',
            'description' => 'Sales of goods for animals, aquarium fish, parrots (accessories, food,
                vitamin supplements, perfumes, clothing, shoes, literature). There is a terminal.',
            'image' => __DIR__ . '/img/05.jpeg',
            'employee' => [
                0 => [
                    'userName' => 'Temur',
                    'password' => 'temur',
                    'phone' => '+998 (90) 222-11-12',
                    'price' => '50000',
                    'image' => __DIR__ . '/img/1.JPG',
                ],
                1 => [
                    'userName' => 'Akbar',
                    'password' => 'akbar',
                    'phone' => '+998 (90) 222-11-20',
                    'price' => '60000',
                    'image' => __DIR__ . '/img/01.jpeg',
                ],
                2 => [
                    'userName' => 'Aziz',
                    'password' => 'aziz',
                    'phone' => '+998 (90) 222-11-30',
                    'price' => '70000',
                    'image' => __DIR__ . '/img/2.JPG',
                ]
            ],
        ],
        [
            'name' => 'Doctor Vet ООО',
            'phone' => '(998) 71-260-11-26',
            'address' => 'Uzbekistan, 100204, Tashkent, YASHNABAD DISTRICT, AVIASOZLAR-2 massif, 56',
            'description' => 'Our company has been operating for 15 years and is an exclusive dealer of world brands!
                We offer you a wide range of world brands:
                    1. Veterinary drugs
                    2. Food for animals, birds and fish.
                    3. Accessories for pets.
                    4. Vaccines for animals.
                    5. Vitamin and mineral complexes for animals
                    6. Pesticides and fertilizers
                    7. Feeders and drinkers for poultry....
                In a word, you can find with us everything for the protection and maintenance of domestic and farm animals and even for plant protection!
                Prices for wholesalers and retailers! Individual approach to each consumer!',
            'image' => __DIR__ . '/img/06.jpeg',
            'employee' => [
                0 => [
                    'userName' => 'Lola',
                    'password' => 'lola',
                    'phone' => '+998 (90) 222-11-40',
                    'price' => '80000',
                    'image' => __DIR__ . '/img/02.webp',
                ],
                1 => [
                    'userName' => 'Anvar',
                    'password' => 'anvar',
                    'phone' => '+998 (90) 222-11-50',
                    'price' => '90000',
                    'image' => __DIR__ . '/img/3.JPG',
                ],
                2 => [
                    'userName' => 'Munisa',
                    'password' => 'munisa',
                    'phone' => '+998 (90) 222-11-60',
                    'price' => '100000',
                    'image' => __DIR__ . '/img/03.jpeg',
                ]
            ],
        ],
        [
            'name' => 'Zoo Doctor',
            'phone' => '(998) 97-754-54-50',
            'address' => 'Tashkent, Mirabad district, st. Mirobod, 33',
            'description' => 'Zoo Doctor Clinic is a place where you will not only help and treat, but also give your pet a gift
                kindness and affection. Love for animals and care for them is something without which our team of doctors would not exist.
                Imagine that our mustachioed and striped patients can receive highly qualified care,
                starting from a consultation with a therapist and ending with their comfortable transportation.
                Modern equipment, laboratories equipped with foreign technology and competent specialists help
                identify any disease and help eliminate it for the sake of a healthy and fulfilling life for the animal.
                A team of specialists even visits home, creating maximum comfort for young patients.
                For real happiness after recovery, we offer haircuts and bathing for your pet, as well as useful,
                inexpensive food and treats for your pet. We do not give health, We preserve it. With love, Zoo Doctor.',
            'image' => __DIR__ . '/img/07.jpeg',
            'employee' => [
                0 => [
                    'userName' => 'Bahrom',
                    'password' => 'bahrom',
                    'phone' => '+998 (90) 222-11-72',
                    'price' => '110000',
                    'image' => __DIR__ . '/img/4.jpeg',
                ],
                1 => [
                    'userName' => 'Madina',
                    'password' => 'madina',
                    'phone' => '+998 (90) 222-11-80',
                    'price' => '120000',
                    'image' => __DIR__ . '/img/04.JPG',
                ],
                2 => [
                    'userName' => 'Luiza',
                    'password' => 'luiza',
                    'phone' => '+998 (90) 222-11-90',
                    'price' => '130000',
                    'image' => __DIR__ . '/img/5.JPG',
                ]
            ],
        ],
        [
            'name' => 'Пес и Кот',
            'phone' => '(998) 90-320-58-33',
            'address' => 'Yakub Kolas, 4',
            'description' => 'At the pet store "Dog and Cat" we are glad to welcome all visitors, owners of a variety of pets.
                On the store shelves you will find a wide range of food for birds, fish, cats, dogs, as well as any
                accessories for caring for animals and organizing a comfortable life for your pets. Experienced sales consultants
                ready to answer all your questions. All pet products and food undergo mandatory and thorough testing.
                We work only with official feed distributors, which is why we can guarantee quality.
                A flexible system of discounts is provided for regular customers. Our salon employs professional
                groomers who know how to approach your pets. Possessing knowledge of the anatomy and psychology of animals.
                We work only with professional cosmetics. Dogs trained in our salon become
                exhibition winners. The beauty and health of your pets fur is in our safe hands!',
            'image' => __DIR__ . '/img/08.jpeg',
            'employee' => [
                0 => [
                    'userName' => 'Azamat',
                    'password' => 'azamat',
                    'phone' => '+998 (90) 222-12-12',
                    'price' => '140000',
                    'image' => __DIR__ . '/img/6.JPG',
                ],
                1 => [
                    'userName' => 'Sevinch',
                    'password' => 'sevinch',
                    'phone' => '+998 (90) 222-20-20',
                    'price' => '150000',
                    'image' => __DIR__ . '/img/7.JPG',
                ],
                2 => [
                    'userName' => 'Diana',
                    'password' => 'diana',
                    'phone' => '+998 (90) 222-30-30',
                    'price' => '160000',
                    'image' => __DIR__ . '/img/8.JPG',
                ]
            ],
        ],
    ];

    public function __construct(
        private readonly UserFactory $userFactory,
        private readonly CategoryFactory $categoryFactory,
        private readonly ClinicFactory $clinicFactory,
        private readonly ServiceFactory $serviceFactory,
        private readonly EmployeeFactory $employeeFactory,
        private readonly Filesystem $filesystem,
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $categories = [];
        $services = [];

        $admin = $this->userFactory->create('Nasiba', 'nasiba', '+998 (90) 222-11-11', null);
        $admin->addRole('ROLE_ADMIN');
        $manager->persist($admin);

        foreach ($this->categories as $item) {
            $category = $this->categoryFactory->create($item['name'], $item['description'], $admin);
            $categories[] = $category;
            $manager->persist($category);
        }

        foreach ($this->services as $item) {
            $service = $this->serviceFactory->create($item['name'], $admin);
            $services[] = $service;
            $manager->persist($service);
        }

        foreach ($this->clinics as $index => $item) {
            $clinic = $this->clinicFactory->create(
                $item['name'],
                $item['phone'],
                $item['address'],
                $item['description'],
                $this->addImage($item, $index, $manager),
                $categories[$index],
                $admin
            );
            $manager->persist($clinic);

            for ($i = 0; $i < 3; $i++) {
                $user = $this->userFactory->create(
                    $item['employee'][$i]['userName'],
                    $item['employee'][$i]['password'],
                    $item['employee'][$i]['phone'],
                    null
                );

                $manager->persist($user);
                $user->addRole('ROLE_DOCTOR');
                $employee = $this->employeeFactory->create($user, $services[$i], $item['employee'][$i]['price'], $clinic, $admin);
                $manager->persist($employee);
            }
        }

        $manager->flush();
    }

    private function addImage(array $item, int $index, ObjectManager $manager): MediaObject
    {
        $tempDir = sys_get_temp_dir();
        $tempFilePath = $tempDir . '/file' . ($index + 1) . '.jpg';
        $this->filesystem->copy($item['image'], $tempFilePath, true);

        $file = new UploadedFile(
            $tempFilePath,
            'file' . ($index + 1) . '.jpg',
            'image/jpeg',
            null,
            true
        );

        $image = new MediaObject();
        $image->file = $file;
        $manager->persist($image);

        return $image;
    }
}
