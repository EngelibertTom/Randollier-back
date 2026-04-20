<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Product;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(
        private readonly UserPasswordHasherInterface $hasher
    ) {}

    public function load(ObjectManager $manager): void
    {
        // ── Categories ────────────────────────────────────────────────────────
        $categoriesData = [
            [
                'name'        => 'Homme',
                'slug'        => 'homme',
                'description' => 'Vêtements et chaussures de randonnée pour homme.',
                'image'       => 'https://images.unsplash.com/photo-1551698618-1dfe5d97d256?auto=format&fit=crop&w=800&q=80',
            ],
            [
                'name'        => 'Femme',
                'slug'        => 'femme',
                'description' => 'Vêtements et chaussures de randonnée pour femme.',
                'image'       => 'https://images.unsplash.com/photo-1544966503-7cc5ac882d5f?auto=format&fit=crop&w=800&q=80',
            ],
            [
                'name'        => 'Sacs',
                'slug'        => 'sacs',
                'description' => 'Sacs à dos, sacs de couchage et accessoires de portage.',
                'image'       => 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?auto=format&fit=crop&w=800&q=80',
            ],
            [
                'name'        => 'Équipements',
                'slug'        => 'equipements',
                'description' => 'Tout l\'équipement pour vos sorties en pleine nature.',
                'image'       => 'https://images.unsplash.com/photo-1478131143081-80f7f84ca84d?auto=format&fit=crop&w=800&q=80',
            ],
        ];

        $categories = [];
        foreach ($categoriesData as $data) {
            $cat = (new Category())
                ->setName($data['name'])
                ->setSlug($data['slug'])
                ->setDescription($data['description'])
                ->setImage($data['image']);
            $manager->persist($cat);
            $categories[$data['slug']] = $cat;
        }

        // ── Products ──────────────────────────────────────────────────────────
        $productsData = [
            // ── Homme ──
            [
                'name'        => 'T-shirt technique homme',
                'slug'        => 't-shirt-technique-homme',
                'description' => 'T-shirt léger en polyester recyclé, idéal pour les longues randonnées. Évacuation rapide de l\'humidité et protection UV.',
                'price'       => '34.90',
                'stock'       => 80,
                'category'    => 'homme',
                'image'       => 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?auto=format&fit=crop&w=600&q=80',
            ],
            [
                'name'        => 'Veste imperméable Gore-Tex homme',
                'slug'        => 'veste-impermeable-gore-tex-homme',
                'description' => 'Veste 3 couches Gore-Tex légère et respirante. Coutures soudées, capuche ajustable. Protection totale contre la pluie.',
                'price'       => '189.00',
                'stock'       => 35,
                'category'    => 'homme',
                'image'       => 'https://images.unsplash.com/photo-1551698618-1dfe5d97d256?auto=format&fit=crop&w=600&q=80',
            ],
            [
                'name'        => 'Chaussures de trail homme',
                'slug'        => 'chaussures-trail-homme',
                'description' => 'Chaussures basses trail-running avec semelle Vibram. Amorti réactif, grip exceptionnel sur terrain sec ou humide.',
                'price'       => '129.00',
                'stock'       => 50,
                'category'    => 'homme',
                'image'       => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?auto=format&fit=crop&w=600&q=80',
            ],
            [
                'name'        => 'Pantalon de randonnée homme',
                'slug'        => 'pantalon-randonnee-homme',
                'description' => 'Pantalon stretch 4 directions, résistant à l\'abrasion. Poches zippées, fond de teint renforcé. Certifié UPF 40+.',
                'price'       => '89.00',
                'stock'       => 45,
                'category'    => 'homme',
                'image'       => 'https://images.unsplash.com/photo-1624378439575-d8705ad7ae80?auto=format&fit=crop&w=600&q=80',
            ],
            [
                'name'        => 'Polaire mid-layer homme',
                'slug'        => 'polaire-mid-layer-homme',
                'description' => 'Polaire en laine Polartec® 200. Chaleur optimale sans surpoids. Idéale en couche intermédiaire ou seule par temps frais.',
                'price'       => '74.90',
                'stock'       => 60,
                'category'    => 'homme',
                'image'       => 'https://images.unsplash.com/photo-1614975059251-992f11792b9f?auto=format&fit=crop&w=600&q=80',
            ],
            [
                'name'        => 'Chaussures de randonnée montantes homme',
                'slug'        => 'chaussures-randonnee-montantes-homme',
                'description' => 'Tige montante en cuir nubuck, membrane imperméable intégrée. Semelle Vibram pour une stabilité optimale en terrain accidenté.',
                'price'       => '159.00',
                'stock'       => 40,
                'category'    => 'homme',
                'image'       => 'https://images.unsplash.com/photo-1608231387042-66d1773d3028?auto=format&fit=crop&w=600&q=80',
            ],

            // ── Femme ──
            [
                'name'        => 'T-shirt technique femme',
                'slug'        => 't-shirt-technique-femme',
                'description' => 'T-shirt ajusté en Merino laine naturelle. Thermorégulation naturelle, anti-odeur, doux sur la peau. Idéal toutes saisons.',
                'price'       => '42.90',
                'stock'       => 75,
                'category'    => 'femme',
                'image'       => 'https://images.unsplash.com/photo-1503342217505-b0a15ec3261c?auto=format&fit=crop&w=600&q=80',
            ],
            [
                'name'        => 'Veste coupe-vent femme',
                'slug'        => 'veste-coupe-vent-femme',
                'description' => 'Veste ultra-légère (180 g) packable dans sa poche. Protection contre le vent et la pluie légère, coutures thermocollées.',
                'price'       => '109.00',
                'stock'       => 40,
                'category'    => 'femme',
                'image'       => 'https://images.unsplash.com/photo-1544966503-7cc5ac882d5f?auto=format&fit=crop&w=600&q=80',
            ],
            [
                'name'        => 'Chaussures de randonnée femme',
                'slug'        => 'chaussures-randonnee-femme',
                'description' => 'Chaussure basse légère avec semelle intermédiaire EVA. Respirante, imperméable et confortable dès la première sortie.',
                'price'       => '119.00',
                'stock'       => 45,
                'category'    => 'femme',
                'image'       => 'https://images.unsplash.com/photo-1595950653106-bde9a92f0a9a?auto=format&fit=crop&w=600&q=80',
            ],
            [
                'name'        => 'Legging trail femme',
                'slug'        => 'legging-trail-femme',
                'description' => 'Legging compression haute performance. Tissu recyclé 4 voies stretch, poche latérale zippée pour smartphone. UPF 50+.',
                'price'       => '64.90',
                'stock'       => 55,
                'category'    => 'femme',
                'image'       => 'https://images.unsplash.com/photo-1506629082955-511b1aa562c8?auto=format&fit=crop&w=600&q=80',
            ],
            [
                'name'        => 'Doudoune légère femme',
                'slug'        => 'doudoune-legere-femme',
                'description' => 'Doudoune garnissage duvet 90/10 (700 cuin). Compressible en son sac de rangement intégré. Idéale bivouac et mi-saison.',
                'price'       => '149.00',
                'stock'       => 30,
                'category'    => 'femme',
                'image'       => 'https://images.unsplash.com/photo-1548036161-74dc1ee6a47e?auto=format&fit=crop&w=600&q=80',
            ],
            [
                'name'        => 'Short randonnée femme',
                'slug'        => 'short-randonnee-femme',
                'description' => 'Short léger avec fond de teint intégré. Tissu séchage rapide, ceinture élastiquée, deux poches latérales.',
                'price'       => '49.90',
                'stock'       => 50,
                'category'    => 'femme',
                'image'       => 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?auto=format&fit=crop&w=600&q=80',
            ],

            // ── Sacs ──
            [
                'name'        => 'Sac à dos randonnée 30L',
                'slug'        => 'sac-a-dos-randonnee-30l',
                'description' => 'Sac à dos 30L avec dos ventilé AirSpeed. Poche hydratation 3L incluse, ceinture ergonomique, poche clés magnétique.',
                'price'       => '95.00',
                'stock'       => 40,
                'category'    => 'sacs',
                'image'       => 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?auto=format&fit=crop&w=600&q=80',
            ],
            [
                'name'        => 'Sac à dos trekking 50L',
                'slug'        => 'sac-a-dos-trekking-50l',
                'description' => 'Grand sac 50L pour les expéditions multi-jours. Armature aluminium, réglage hauteur de dos, pluvier intégré.',
                'price'       => '159.00',
                'stock'       => 25,
                'category'    => 'sacs',
                'image'       => 'https://images.unsplash.com/photo-1491553895911-0055eca6402d?auto=format&fit=crop&w=600&q=80',
            ],
            [
                'name'        => 'Sac de couchage 3 saisons',
                'slug'        => 'sac-de-couchage-3-saisons',
                'description' => 'Sac de couchage momie confort +5°C / limite -5°C. Garnissage duvet synthétique DryLoft, fermeture éclair double sens.',
                'price'       => '119.00',
                'stock'       => 30,
                'category'    => 'sacs',
                'image'       => 'https://images.unsplash.com/photo-1504280390367-361c6d9f38f4?auto=format&fit=crop&w=600&q=80',
            ],
            [
                'name'        => 'Sac banane trail 5L',
                'slug'        => 'sac-banane-trail-5l',
                'description' => 'Sac banane d\'hydratation 5L avec poche souple 1,5L. Légèreté et stabilité pour les sorties trail et fastpacking.',
                'price'       => '49.90',
                'stock'       => 55,
                'category'    => 'sacs',
                'image'       => 'https://images.unsplash.com/photo-1622560480605-d83c853bc5c3?auto=format&fit=crop&w=600&q=80',
            ],
            [
                'name'        => 'Sac à dos daypack 20L',
                'slug'        => 'sac-a-dos-daypack-20l',
                'description' => 'Sac léger 20L idéal pour les sorties journée. Poche laptop 15 pouces, bretelles matelassées, tissu ripstop résistant.',
                'price'       => '59.00',
                'stock'       => 45,
                'category'    => 'sacs',
                'image'       => 'https://images.unsplash.com/photo-1473188588951-666fce8e7c68?auto=format&fit=crop&w=600&q=80',
            ],

            // ── Équipements ──
            [
                'name'        => 'Bâtons de randonnée aluminium',
                'slug'        => 'batons-randonnee-aluminium',
                'description' => 'Paire de bâtons télescopiques en aluminium 7075. Poignées liège, dragonne réglable, embouts carbure interchangeables.',
                'price'       => '59.00',
                'stock'       => 60,
                'category'    => 'equipements',
                'image'       => 'https://images.unsplash.com/photo-1561940157-a5e3f39df55b?auto=format&fit=crop&w=600&q=80',
            ],
            [
                'name'        => 'Gourde isotherme 1L',
                'slug'        => 'gourde-isotherme-1l',
                'description' => 'Gourde double paroi inox 304. Maintien au froid 24h, au chaud 12h. Bouchon large bouche, sans BPA. Poids : 310 g.',
                'price'       => '34.90',
                'stock'       => 90,
                'category'    => 'equipements',
                'image'       => 'https://images.unsplash.com/photo-1602143407151-7111542de6e8?auto=format&fit=crop&w=600&q=80',
            ],
            [
                'name'        => 'Tente 2 places ultra-légère',
                'slug'        => 'tente-2-places-ultra-legere',
                'description' => 'Tente autoportante double toit, poteaux DAC aluminium. Poids total 1,8 kg. Résistance au vent jusqu\'à 80 km/h.',
                'price'       => '299.00',
                'stock'       => 20,
                'category'    => 'equipements',
                'image'       => 'https://images.unsplash.com/photo-1478131143081-80f7f84ca84d?auto=format&fit=crop&w=600&q=80',
            ],
            [
                'name'        => 'Frontale rechargeable 450 lm',
                'slug'        => 'frontale-rechargeable-450-lm',
                'description' => 'Frontale LED 450 lumens, rechargeable USB-C. Autonomie jusqu\'à 8h, résistante à l\'eau IPX4. Faisceau hybride proche/lointain.',
                'price'       => '44.90',
                'stock'       => 70,
                'category'    => 'equipements',
                'image'       => 'https://images.unsplash.com/photo-1565814329452-e5a71e2e4b9c?auto=format&fit=crop&w=600&q=80',
            ],
            [
                'name'        => 'Matelas de sol isolant',
                'slug'        => 'matelas-de-sol-isolant',
                'description' => 'Matelas autogonflant R-Value 3.5. Confort optimisé, tissu 40D nylon résistant aux déchirures. Format compact pour le transport.',
                'price'       => '79.00',
                'stock'       => 35,
                'category'    => 'equipements',
                'image'       => 'https://images.unsplash.com/photo-1504280390367-361c6d9f38f4?auto=format&fit=crop&w=600&q=80',
            ],
            [
                'name'        => 'Réchaud à gaz ultraléger',
                'slug'        => 'rechaud-gaz-ultraleger',
                'description' => 'Réchaud piezzo compatible cartouches Lindal. Poids 85 g, puissance 2800 W. Livré avec son étui de protection.',
                'price'       => '54.90',
                'stock'       => 45,
                'category'    => 'equipements',
                'image'       => 'https://images.unsplash.com/photo-1533575770077-052fa2c609fc?auto=format&fit=crop&w=600&q=80',
            ],
        ];

        foreach ($productsData as $data) {
            $product = (new Product())
                ->setName($data['name'])
                ->setSlug($data['slug'])
                ->setDescription($data['description'])
                ->setPrice($data['price'])
                ->setStock($data['stock'])
                ->setImage($data['image'])
                ->setIsActive(true)
                ->setCategory($categories[$data['category']]);
            $manager->persist($product);
        }

        // ── Admin user ─────────────────────────────────────────────────────────
        $admin = new User();
        $admin->setEmail('admin@randollier.fr');
        $admin->setFirstName('Admin');
        $admin->setLastName('Randollier');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setPassword($this->hasher->hashPassword($admin, 'admin1234'));
        $manager->persist($admin);

        $manager->flush();
    }
}
