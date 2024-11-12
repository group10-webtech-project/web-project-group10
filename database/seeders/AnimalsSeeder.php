<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AnimalsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get category IDs
        $categories = DB::table('categories')->select('id', 'name')->get();
        $categoryIds = [];
        foreach ($categories as $category) {
            $categoryIds[$category->name] = $category->id;
        }

        $animals = [
            // Invertebrates
            [
                'name' => 'Giant Pacific Octopus',
                'size' => 'Up to 16 feet arm span',
                'habitat' => 'Marine',
                'diet' => 'Carnivore',
                'region' => 'North Pacific Ocean',
                'lifespan' => '3-5 years',
                'category_id' => $categoryIds['Invertebrates'],
                'description' => 'The Giant Pacific Octopus is one of the most intelligent invertebrates, known for its problem-solving abilities and color-changing camouflage. They can use tools, solve puzzles, and have been known to escape from aquariums.',
                'image_url' => 'octopus.jpg',
            ],
            [
                'name' => 'Emperor Butterfly',
                'size' => '4-inch wingspan',
                'habitat' => 'Tropical forests',
                'diet' => 'Nectar',
                'region' => 'South America',
                'lifespan' => '6-8 months',
                'category_id' => $categoryIds['Invertebrates'],
                'description' => 'These magnificent butterflies are known for their striking blue iridescent wings and complex social behaviors. They play a crucial role in pollination within their ecosystem.',
                'image_url' => 'butterfly.jpg',
            ],
            [
                'name' => 'Giant Australian Cuttlefish',
                'size' => 'Up to 20 inches',
                'habitat' => 'Marine reefs',
                'diet' => 'Carnivore',
                'region' => 'Southern Australian waters',
                'lifespan' => '2-4 years',
                'category_id' => $categoryIds['Invertebrates'],
                'description' => 'Masters of disguise, these cephalopods can instantly change their color and texture to match their surroundings. Males put on spectacular displays during mating season.',
                'image_url' => 'cuttlefish.jpg',
            ],
            [
                'name' => 'Goliath Bird-Eating Spider',
                'size' => '11-inch leg span',
                'habitat' => 'Rainforest floor',
                'diet' => 'Carnivore',
                'region' => 'South America',
                'lifespan' => '15-25 years',
                'category_id' => $categoryIds['Invertebrates'],
                'description' => 'The largest spider by mass, this tarantula species can consume small birds, though it primarily feeds on insects and small vertebrates. Despite its intimidating size, it rarely poses a threat to humans.',
                'image_url' => 'spider.jpg',
            ],
            [
                'name' => 'Giant Clam',
                'size' => 'Up to 4 feet wide',
                'habitat' => 'Coral reefs',
                'diet' => 'Filter feeder',
                'region' => 'Indo-Pacific',
                'lifespan' => 'Over 100 years',
                'category_id' => $categoryIds['Invertebrates'],
                'description' => 'These massive bivalves can weigh up to 500 pounds. They form symbiotic relationships with algae and are crucial to reef ecosystems. Their shells can be brightly colored due to the presence of photosynthetic algae.',
                'image_url' => 'clam.jpg',
            ],

            // Fish
            [
                'name' => 'Great White Shark',
                'size' => 'Up to 20 feet',
                'habitat' => 'Marine',
                'diet' => 'Carnivore',
                'region' => 'Global oceans',
                'lifespan' => '70+ years',
                'category_id' => $categoryIds['Fish'],
                'description' => 'The largest predatory fish, great whites are known for their size and powerful jaws. Despite their fearsome reputation, they rarely attack humans and are crucial for ocean ecosystem balance.',
                'image_url' => 'shark.jpg',
            ],
            [
                'name' => 'Electric Eel',
                'size' => 'Up to 8 feet',
                'habitat' => 'Freshwater',
                'diet' => 'Carnivore',
                'region' => 'South America',
                'lifespan' => '15-20 years',
                'category_id' => $categoryIds['Fish'],
                'description' => 'Despite their name, they are not true eels but belong to the knifefish family. They can generate electric charges up to 860 volts to stun prey and defend themselves.',
                'image_url' => 'eel.jpg',
            ],
            [
                'name' => 'Ocean Sunfish',
                'size' => 'Up to 14 feet',
                'habitat' => 'Marine',
                'diet' => 'Omnivore',
                'region' => 'Tropical and temperate oceans',
                'lifespan' => '20-30 years',
                'category_id' => $categoryIds['Fish'],
                'description' => 'The heaviest known bony fish, sunfish can weigh up to 5,000 pounds. They often bask on their sides at the surface, leading to their name. Their diet consists mainly of jellyfish.',
                'image_url' => 'sunfish.jpg',
            ],
            [
                'name' => 'Seahorse',
                'size' => '0.6-14 inches',
                'habitat' => 'Marine',
                'diet' => 'Carnivore',
                'region' => 'Global tropical waters',
                'lifespan' => '1-5 years',
                'category_id' => $categoryIds['Fish'],
                'description' => 'Unique among fish, male seahorses carry and give birth to young. They use their prehensile tails to anchor themselves and are masters of camouflage.',
                'image_url' => 'seahorse.jpg',
            ],
            [
                'name' => 'Flying Fish',
                'size' => 'Up to 18 inches',
                'habitat' => 'Marine',
                'diet' => 'Omnivore',
                'region' => 'Tropical and subtropical oceans',
                'lifespan' => '5 years',
                'category_id' => $categoryIds['Fish'],
                'description' => 'These remarkable fish can leap out of water and glide for distances up to 200 meters using their enlarged pectoral fins as wings. This ability helps them escape predators.',
                'image_url' => 'flying-fish.jpg',
            ],

            // Amphibians
            [
                'name' => 'Chinese Giant Salamander',
                'size' => 'Up to 6 feet',
                'habitat' => 'Freshwater',
                'diet' => 'Carnivore',
                'region' => 'China',
                'lifespan' => '60+ years',
                'category_id' => $categoryIds['Amphibians'],
                'description' => 'The largest amphibian in the world, these salamanders can detect prey using special sensory nodes that run along their bodies. They are considered living fossils, having remained largely unchanged for millions of years.',
                'image_url' => 'salamander.jpg',
            ],
            [
                'name' => 'Red-Eyed Tree Frog',
                'size' => '2-3 inches',
                'habitat' => 'Rainforest',
                'diet' => 'Carnivore',
                'region' => 'Central America',
                'lifespan' => '5-10 years',
                'category_id' => $categoryIds['Amphibians'],
                'description' => 'Known for their vibrant red eyes and bright green bodies, these iconic rainforest amphibians are excellent climbers. They sleep during the day with their eyes closed, blending in with leaves.',
                'image_url' => 'tree-frog.jpg',
            ],
            [
                'name' => 'Fire Salamander',
                'size' => '6-8 inches',
                'habitat' => 'Forest',
                'diet' => 'Carnivore',
                'region' => 'Europe',
                'lifespan' => '20-30 years',
                'category_id' => $categoryIds['Amphibians'],
                'description' => 'Their striking black and yellow coloration warns predators of their toxic skin secretions. They are one of the few salamanders that give birth to live young instead of laying eggs.',
                'image_url' => 'fire-salamander.jpg',
            ],
            [
                'name' => 'Poison Dart Frog',
                'size' => '1-2 inches',
                'habitat' => 'Rainforest',
                'diet' => 'Carnivore',
                'region' => 'South America',
                'lifespan' => '3-15 years',
                'category_id' => $categoryIds['Amphibians'],
                'description' => 'Among the most toxic animals on Earth, their bright colors warn predators of their potent poison. In captivity, they become non-toxic due to their specialized wild diet.',
                'image_url' => 'dart-frog.jpg',
            ],
            [
                'name' => 'Axolotl',
                'size' => '8-12 inches',
                'habitat' => 'Freshwater',
                'diet' => 'Carnivore',
                'region' => 'Mexico',
                'lifespan' => '10-15 years',
                'category_id' => $categoryIds['Amphibians'],
                'description' => 'These salamanders never undergo metamorphosis, keeping their larval features throughout life. They can regenerate entire lost limbs and organs, making them valuable for scientific research.',
                'image_url' => 'axolotl.jpg',
            ],

            // Reptiles
            [
                'name' => 'Komodo Dragon',
                'size' => 'Up to 10 feet',
                'habitat' => 'Island scrubland',
                'diet' => 'Carnivore',
                'region' => 'Indonesia',
                'lifespan' => '30 years',
                'category_id' => $categoryIds['Reptiles'],
                'description' => 'The largest living species of lizard, Komodo dragons are apex predators known for their powerful bite and bacteria-laden saliva. They can eat up to 80% of their body weight in a single meal.',
                'image_url' => 'komodo.jpg',
            ],
            [
                'name' => 'Galapagos Tortoise',
                'size' => '4-5 feet shell length',
                'habitat' => 'Islands',
                'diet' => 'Herbivore',
                'region' => 'Galapagos Islands',
                'lifespan' => '100+ years',
                'category_id' => $categoryIds['Reptiles'],
                'description' => 'The longest-lived of all vertebrates, these giant tortoises can live over 100 years. Different islands have tortoises with differently shaped shells, adapted to their specific environments.',
                'image_url' => 'tortoise.jpg',
            ],
            [
                'name' => 'King Cobra',
                'size' => 'Up to 18 feet',
                'habitat' => 'Forest',
                'diet' => 'Carnivore',
                'region' => 'Southeast Asia',
                'lifespan' => '20 years',
                'category_id' => $categoryIds['Reptiles'],
                'description' => 'The longest venomous snake in the world, king cobras primarily eat other snakes. They are known for their intelligence and are the only snakes that build nests for their eggs.',
                'image_url' => 'cobra.jpg',
            ],
            [
                'name' => 'Saltwater Crocodile',
                'size' => 'Up to 23 feet',
                'habitat' => 'Coastal waters',
                'diet' => 'Carnivore',
                'region' => 'Southeast Asia to Australia',
                'lifespan' => '70+ years',
                'category_id' => $categoryIds['Reptiles'],
                'description' => 'The largest living reptile and most powerful bite force of any animal. They can live in both fresh and saltwater and are excellent swimmers, known to travel long distances across open ocean.',
                'image_url' => 'crocodile.jpg',
            ],
            [
                'name' => 'Chameleon',
                'size' => '4-27 inches',
                'habitat' => 'Forest',
                'diet' => 'Carnivore',
                'region' => 'Africa and Madagascar',
                'lifespan' => '5-10 years',
                'category_id' => $categoryIds['Reptiles'],
                'description' => 'Famous for their ability to change color, chameleons also have independently moving eyes, extremely long tongues, and grasping feet. They change color for communication and temperature regulation, not just camouflage.',
                'image_url' => 'chameleon.jpg',
            ],

            // Birds
            [
                'name' => 'Wandering Albatross',
                'size' => '11.5 feet wingspan',
                'habitat' => 'Marine',
                'diet' => 'Carnivore',
                'region' => 'Southern Ocean',
                'lifespan' => '50+ years',
                'category_id' => $categoryIds['Birds'],
                'description' => 'Having the largest wingspan of any living bird, these seabirds can glide for hours without flapping their wings. They mate for life and spend most of their lives at sea, returning to land only to breed.',
                'image_url' => 'albatross.jpg',
            ],
            [
                'name' => 'Peregrine Falcon',
                'size' => '3.3-3.6 feet wingspan',
                'habitat' => 'Various',
                'diet' => 'Carnivore',
                'region' => 'Worldwide',
                'lifespan' => '15-20 years',
                'category_id' => $categoryIds['Birds'],
                'description' => 'The fastest animal on Earth, reaching speeds over 240 mph during hunting dives. They are found on every continent except Antarctica and have adapted to live in cities, nesting on skyscrapers.',
                'image_url' => 'falcon.jpg',
            ],
            [
                'name' => 'Emperor Penguin',
                'size' => '4 feet tall',
                'habitat' => 'Antarctic',
                'diet' => 'Carnivore',
                'region' => 'Antarctica',
                'lifespan' => '20 years',
                'category_id' => $categoryIds['Birds'],
                'description' => 'The largest penguin species, they survive the harsh Antarctic winter by huddling together in large groups. Males incubate eggs on their feet under a flap of skin while females travel up to 50 miles to feed.',
                'image_url' => 'penguin.jpg',
            ],
            [
                'name' => 'Common Raven',
                'size' => '4.5 feet wingspan',
                'habitat' => 'Various',
                'diet' => 'Omnivore',
                'region' => 'Northern Hemisphere',
                'lifespan' => '10-15 years',
                'category_id' => $categoryIds['Birds'],
                'description' => 'Among the most intelligent of all birds, ravens can solve complex problems, use tools, and even mimic human speech. They are known to play games, create toys, and work cooperatively to find food.',
                'image_url' => 'raven.jpg',
            ],
            [
                'name' => 'Harpy Eagle',
                'size' => '6.5 feet wingspan',
                'habitat' => 'Rainforest',
                'diet' => 'Carnivore',
                'region' => 'Central and South America',
                'lifespan' => '25-35 years',
                'category_id' => $categoryIds['Birds'],
                'description' => 'One of the most powerful eagles, with talons the size of grizzly bear claws. They can lift prey equal to their own body weight and are considered sacred by many indigenous peoples.',
                'image_url' => 'harpy.jpg',
            ],

            // Mammals
            [
                'name' => 'African Elephant',
                'size' => 'Up to 13 feet tall',
                'habitat' => 'Savanna',
                'diet' => 'Herbivore',
                'region' => 'Africa',
                'lifespan' => '60-70 years',
                'category_id' => $categoryIds['Mammals'],
                'description' => 'The largest land animal, known for their intelligence, complex social structures, and remarkable memory. They play a crucial role in maintaining their ecosystem as keystone species.',
                'image_url' => 'elephant.jpg',
            ],
            [
                'name' => 'Blue Whale',
                'size' => 'Up to 100 feet',
                'habitat' => 'Marine',
                'diet' => 'Carnivore',
                'region' => 'Global oceans',
                'lifespan' => '80-90 years',
                'category_id' => $categoryIds['Mammals'],
                'description' => 'The largest animal known to have ever existed, blue whales can weigh up to 200 tons. Their hearts are the size of a car, and their songs can be heard for hundreds of miles underwater.',
                'image_url' => 'whale.jpg',
            ],
            [
                'name' => 'Red Kangaroo',
                'size' => 'Up to 6 feet tall',
                'habitat' => 'Desert and grassland',
                'diet' => 'Herbivore',
                'region' => 'Australia',
                'lifespan' => '20-25 years',
                'category_id' => $categoryIds['Mammals'],
                'description' => 'The largest marsupial alive today, known for their powerful legs and tail. They can travel at speeds up to 35mph and their joeys develop in a pouch for several months after birth.',
                'image_url' => 'kangaroo.jpg',
            ],
            [
                'name' => 'Arctic Fox',
                'size' => '2-3 feet long',
                'habitat' => 'Tundra',
                'diet' => 'Carnivore',
                'region' => 'Arctic Circle',
                'lifespan' => '3-6 years',
                'category_id' => $categoryIds['Mammals'],
                'description' => 'Their fur changes color seasonally - white in winter and brown in summer - for perfect camouflage. They can survive temperatures as low as -50°C and their round, furry bodies help conserve heat.',
                'image_url' => 'fox.jpg',
            ],
            [
                'name' => 'Orangutan',
                'size' => '4-5 feet tall',
                'habitat' => 'Rainforest',
                'diet' => 'Omnivore',
                'region' => 'Borneo and Sumatra',
                'lifespan' => '35-45 years',
                'category_id' => $categoryIds['Mammals'],
                'description' => 'Among our closest relatives, orangutans are highly intelligent apes known for their tool use and complex cultural behaviors. They spend most of their time in trees and build nests each night for sleeping.',
                'image_url' => 'orangutan.jpg',
            ],
        ];

        $now = now();
        $animals = array_map(function($animal) use ($now) {
            return array_merge($animal, [
                'created_at' => $now,
                'updated_at' => $now
            ]);
        }, $animals);

        DB::table('animals')->insert($animals);
    }
}
