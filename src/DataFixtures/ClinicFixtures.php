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
            'name' => 'Стоматологические клиники',
            'description' => 'Стоматологические клиники предлагают полный спектр услуг для заботы о вашей улыбке. От профессиональной гигиены и лечения кариеса до ортодонтии и имплантологии, мы обеспечим вашим зубам здоровье и красоту.',
        ],
        [   "name" => 'Онкологические клиники',
            'description' => 'В онкологических клиниках работают врачи-онкологи, специализирующиеся на диагностике, лечении и реабилитации пациентов с онкологическими заболеваниями. Мы предоставляем индивидуальный подход и передовые методы лечения для достижения наилучших результатов.',
        ],
        [
            "name" => 'Терапевтические клиники',
            'description' => 'Терапевтические клиники предлагают широкий спектр медицинских услуг, включая диагностику и лечение различных заболеваний. Наши врачи-терапевты обеспечат вас качественной медицинской помощью и заботой о вашем здоровье.',
        ],
        [
            "name" => 'Травматологические клиники',
            'description' => 'В травматологических клиниках работают специалисты по лечению травм и ортопедических заболеваний. Мы предлагаем комплексный подход к лечению травм, реабилитации и восстановлению функций опорно-двигательной системы.',
        ],
        [
            "name" => 'Хирургические клиники',
            'description' => 'Хирургические клиники предоставляют услуги по плановым и экстренным операциям различного характера. Наши высококвалифицированные хирурги обеспечат вас безопасной и эффективной хирургической помощью.',
        ],
        [
            "name" => 'Лабораторно-испытательные клиники',
            'description' => 'Лабораторно-испытательные клиники предлагают широкий спектр лабораторных исследований для диагностики различных заболеваний. Мы используем передовые технологии и методики для точной и быстрой диагностики.',
        ],
        [
            "name" => 'Эндоскопические клиники',
            'description' => 'Эндоскопические клиники специализируются на диагностике и лечении заболеваний с использованием эндоскопических методов. Наши специалисты проведут процедуры с максимальным комфортом и минимальными рисками для пациента.',
        ],
        [
            "name" => 'Инфекционные клиники',
            'description' => 'Инфекционные клиники специализируются на диагностике, лечении и профилактике инфекционных заболеваний. Наши врачи обеспечат вас компетентной помощью и рекомендациями по предотвращению инфекций.',
        ],
        [
            "name" => 'Клиники вакцинации',
            'description' => 'Клиники вакцинации предлагают широкий выбор вакцин для профилактики различных инфекционных заболеваний. Мы гарантируем качественные вакцины и профессиональное введение с учетом всех медицинских стандартов.',
        ],
    ];

    private array$services = [
        [
            'name' => 'Общий врач',
        ],
        [
            'name' => 'Хирург',
        ],
        [
            'name' => 'Терапевт',
        ]
    ];
    private array $clinics = [
        [
            'name' => 'Doktor & Animal',
            'phone' => '(998) 71-268-40-26',
            'address' => 'Узбекистан, Ташкент, МИРЗО-УЛУГБЕКСКИЙ РАЙОН, просп. МИРЗО УЛУГБЕКА, 40',
            'description' => 'Реализация товаров для животных, аквариумных рыб, попугаев (аксессуары, корма, 
                витаминные добавки, парфюмерия, одежда, обувь, литература). Имеется терминал.',
            'image' => __DIR__ . '/img/05.jpeg',
            'employee' => [
                0 => [
                    'userName' => 'Темур',
                    'password' => 'темур',
                    'phone' => '+998 (90) 222-11-12',
                    'price' => '50000',
                    'room' => 'А',
                    'image' => __DIR__ . '/img/1.JPG',
                ],
                1 => [
                    'userName' => 'Акбар',
                    'password' => 'акбар',
                    'phone' => '+998 (90) 222-11-20',
                    'price' => '60000',
                    'room' => 'Б',
                    'image' => __DIR__ . '/img/01.jpeg',
                ],
                2 => [
                    'userName' => 'Азиз',
                    'password' => 'азиз',
                    'phone' => '+998 (90) 222-11-30',
                    'price' => '70000',
                    'room' => 'В',
                    'image' => __DIR__ . '/img/2.JPG',
                ]
            ],
        ],
        [
            'name' => 'Doctor Vet ООО',
            'phone' => '(998) 71-260-11-26',
            'address' => 'Узбекистан, 100204, Ташкент, ЯШНАБАДСКИЙ РАЙОН, м-в АВИАСОЗЛАР-2, 56',
            'description' => 'Наша компания ведет свою деятельность в протяжении 15 лет и является эксклюзивным дилерам мировых брендов!
                Мы предлагаем вам широкий ассортимент от мировых брендов:
                    1. Ветеринарные препараты
                    2. Корма для животных, птиц и рыб.
                    3. Аксессуары для домашних животных.
                    4. Вакцины для животных.
                    5. Витаминно-минеральные комплексы для животных
                    6. Пестициды и удобрения
                    7. Кормушки и поилки для домашних птиц....
                Одним словом вы можете найти у нас все для защиты и содержания домашних и сельскохозяйственных животных и даже для защиты растений!
                Цены для оптовиков и для розничной торговли! Индивидуальный подход к каждому потребителю!',
            'image' => __DIR__ . '/img/06.jpeg',
            'employee' => [
                0 => [
                    'userName' => 'Лола',
                    'password' => 'лола',
                    'phone' => '+998 (90) 222-11-40',
                    'price' => '80000',
                    'room' => 'Г',
                    'image' => __DIR__ . '/img/02.webp',
                ],
                1 => [
                    'userName' => 'Анвар',
                    'password' => 'анвар',
                    'phone' => '+998 (90) 222-11-50',
                    'price' => '90000',
                    'room' => 'Д',
                    'image' => __DIR__ . '/img/3.JPG',
                ],
                2 => [
                    'userName' => 'Муниса',
                    'password' => 'муниса',
                    'phone' => '+998 (90) 222-11-60',
                    'price' => '100000',
                    'room' => 'Е',
                    'image' => __DIR__ . '/img/03.jpeg',
                ]
            ],
        ],
        [
            'name' => 'Zoo Doctor',
            'phone' => '(998) 97-754-54-50',
            'address' => 'г. Ташкент, Мирабадский район, ул. Миробод, д. 33',
            'description' => 'Клиника Zoo Doctor - место, где не только помогут и вылечат, но и подарят вашему питомцу 
                доброту и ласку. Любовь к животным, а также забота о них – то, без чего нашей команды врачей не существовало бы.
                Представьте, что наши усатые-полосатые пациенты могут получить высококвалифицированную помощь, 
                начинающуюся от консультации терапевта и заканчивающуюся их комфортабельной транспортировкой. 
                Современное оборудование, оснащенные иностранной техникой лаборатории и грамотные специалисты помогают 
                выявить любое заболевание и способствовать его устранению ради здоровой и полноценной жизни животного. 
                Команда специалистов выезжает даже на дом, создавая максимальный комфорт маленьким пациентам.
                Для настоящего счастья после выздоровления, мы предлагаем стрижку и купание вашего питомца, а так же полезные, 
                не дорогие корма и лакомства для вашего любимца. Мы не дарим здоровье, Мы его Сохраняем. С любовью, Zoo Doctor.',
            'image' => __DIR__ . '/img/07.jpeg',
            'employee' => [
                0 => [
                    'userName' => 'Бахром',
                    'password' => 'бахром',
                    'phone' => '+998 (90) 222-11-72',
                    'price' => '110000',
                    'room' => 'К',
                    'image' => __DIR__ . '/img/4.jpeg',
                ],
                1 => [
                    'userName' => 'Мадина',
                    'password' => 'мадина',
                    'phone' => '+998 (90) 222-11-80',
                    'price' => '120000',
                    'room' => 'Л',
                    'image' => __DIR__ . '/img/04.JPG',
                ],
                2 => [
                    'userName' => 'Луиза',
                    'password' => 'луиза',
                    'phone' => '+998 (90) 222-11-90',
                    'price' => '130000',
                    'room' => 'М',
                    'image' => __DIR__ . '/img/5.JPG',
                ]
            ],
        ],
        [
            'name' => 'Пес и Кот',
            'phone' => '(998) 90-320-58-33',
            'address' => 'Якуба Коласа, 4',
            'description' => 'В зоомагазине «Пес и Кот» мы рады приветствовать всех посетителей, владельцев разнообразных домашних животных.
                На полках магазина вы найдёте широкий ассортимент кормов для птиц, рыб, кошек, собак, а также любые 
                аксессуары для ухода за животными и организации комфортной жизни своих любимцев. Опытные продавцы-консультанты 
                готовы ответить на все ваши вопросы. Все зоотовары и корма проходят обязательную и тщательную проверку.
                Мы работаем только с официальными дистрибьютерами кормов, именно поэтому можем гарантировать качество.
                Для постоянных клиентов предусмотрена гибкая система скидок. В нашем салоне работают профессиональные 
                грумеры умеющие найти подход к Вашем питомцам. Владеющие знаниями анатомии и психологии животных.
                Мы работаем только с профессиональной косметикой. Собаки, подготовленные в нашем салоне, становятся 
                победителями выставок. Красота и здоровье шерсти Ваших питомцев в наших надёжных руках!',
            'image' => __DIR__ . '/img/08.jpeg',
            'employee' => [
                0 => [
                    'userName' => 'Азамат',
                    'password' => 'азамат',
                    'phone' => '+998 (90) 222-12-12',
                    'price' => '140000',
                    'room' => 'Н',
                    'image' => __DIR__ . '/img/6.JPG',
                ],
                1 => [
                    'userName' => 'Севинч',
                    'password' => 'севинч',
                    'phone' => '+998 (90) 222-20-20',
                    'price' => '150000',
                    'room' => 'О',
                    'image' => __DIR__ . '/img/7.JPG',
                ],
                2 => [
                    'userName' => 'Диана',
                    'password' => 'диана',
                    'phone' => '+998 (90) 222-30-30',
                    'price' => '160000',
                    'room' => 'П',
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

        $admin = $this->userFactory->create('Админ', 'админ', '+998 (90) 222-11-11', null);
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
                    $this->addImage($item['employee'][$i], $index, $manager)
                );

                $manager->persist($user);
                $user->addRole('ROLE_DOCTOR');
                $employee = $this->employeeFactory->create($user, $services[$i], $item['employee'][$i]['price'], $item['employee'][$i]['room'], $clinic, $admin);
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
