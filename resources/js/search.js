/*
const all_options =[
    "lion",
    "tiger",
    "elephant",
    "giraffe",
    "zebra",
    "kangaroo",
    "panda",
    "koala",
    "leopard",
    "cheetah",
    "bear",
    "wolf",
    "fox",
    "deer",
    "rabbit",
    "squirrel",
    "horse",
    "sheep",
    "goat",
    "cow",
    "buffalo",
    "camel",
    "donkey",
    "monkey",
    "chimpanzee",
    "gorilla",
    "orangutan",
    "dolphin",
    "whale",
    "shark",
    "octopus",
    "penguin",
    "eagle",
    "falcon",
    "hawk",
    "owl",
    "peacock",
    "flamingo",
    "parrot",
    "sparrow",
    "crow",
    "pigeon",
    "chicken",
    "duck",
    "goose",
    "turkey",
    "swan",
    "frog",
    "toad",
    "snake",
    "crocodile",
    "alligator",
    "turtle",
    "lizard",
    "iguana",
    "chameleon",
    "ant",
    "bee",
    "butterfly",
    "spider",
    "scorpion",
    "crab",
    "lobster",
    "jellyfish",
    "starfish",
    "seahorse",
    "manta ray",
    "pufferfish",
    "salmon",
    "trout",
    "catfish",
    "hedgehog",
    "raccoon",
    "badger",
    "otter",
    "skunk",
    "mole",
    "bat",
    "armadillo",
    "porcupine",
    "platypus",
    "moose",
    "reindeer",
    "caribou",
    "hyena",
    "jackal",
    "coyote",
    "buffalo",
    "bison",
    "gazelle",
    "impala",
    "okapi",
    "tapir",
    "sloth",
    "anteater",
    "aardvark",
    "wombat",
    "lynx",
    "ocelot",
    "serval",
    "caracal",
    "bobcat"
];*/

const animals = new Map([
    ["lion", "The lion is known as the 'king of the jungle.' It’s a powerful predator found in Africa and parts of Asia. Male lions are known for their majestic manes, which make them stand out. Lions are social animals that live in groups called prides, consisting of females, their cubs, and a few males. They are primarily nocturnal and use teamwork to hunt large prey such as zebras, antelopes, and buffalo. Lions can sleep up to 20 hours a day to conserve energy for hunting and protecting their territory."],
    ["tiger", "Tigers are the largest species in the cat family and are known for their distinctive orange and black stripes. Found primarily in Asia, they prefer dense forests and grasslands. Tigers are solitary hunters, and their strong bodies and sharp claws make them formidable predators. They are excellent swimmers and often cool off in rivers or lakes. Unfortunately, tigers are endangered due to habitat loss and poaching. Conservation efforts focus on protecting their natural habitats and preventing illegal hunting to ensure their survival for future generations."],
    ["elephant", "Elephants are the largest land animals and are known for their intelligence, long trunks, and large ears. Found in Africa and Asia, elephants live in groups led by an older female called a matriarch. They use their trunks for breathing, grasping objects, and communicating. Elephants are highly social and display behaviors like empathy and mourning. They play a crucial role in ecosystems by creating waterholes and clearing trees. Sadly, they face threats from habitat loss and ivory poaching. Conservation efforts are vital for protecting elephant populations and maintaining biodiversity."],
    ["giraffe", "Giraffes are the tallest land animals, native to Africa's savannas and woodlands. Known for their long necks, giraffes have adapted to reach leaves high in trees that other herbivores cannot access. They have unique coat patterns that help with camouflage and vary between individuals. Giraffes are generally social, living in loosely organized groups. Their strong legs and hooves can deter predators like lions. Giraffes face threats from habitat loss and poaching, but conservation measures focus on preserving their natural habitats and managing populations within reserves."],
    ["zebra", "Zebras are herbivorous animals native to Africa, known for their distinctive black-and-white striped coats. Each zebra has a unique stripe pattern, which may help camouflage them from predators. Zebras are highly social and live in herds, forming strong bonds with family members. They have a keen sense of hearing and sight, which helps them avoid predators like lions and hyenas. Zebras are grazers, feeding primarily on grasses. Habitat loss and hunting have reduced zebra populations, but they are protected in many national parks and reserves throughout Africa."],
    ["kangaroo", "Kangaroos are marsupials native to Australia, famous for their powerful hind legs and distinctive hopping locomotion. They are the largest members of the marsupial family and have pouches where females carry their young, called joeys. Kangaroos live in social groups known as mobs and primarily feed on grasses and leaves. Their strong tails provide balance, and they can travel long distances at high speeds. Kangaroos play an essential role in Australian ecosystems, but they sometimes face challenges from human activity and habitat loss."],
    ["panda", "Giant pandas are native to the bamboo forests of China and are easily recognized by their black-and-white fur. They are mostly herbivorous, with bamboo making up over 99% of their diet. Pandas are solitary and spend much of their time eating to meet their high energy needs. Due to habitat loss and low reproductive rates, pandas were once critically endangered, but conservation efforts and habitat restoration have helped stabilize their population. Today, they remain a symbol of wildlife conservation worldwide."],
    ["koala", "Koalas are arboreal marsupials native to Australia, known for their thick fur and distinctive large noses. They primarily feed on eucalyptus leaves, which provide most of their hydration needs. Koalas are solitary and spend most of their time resting in trees, sleeping up to 18-20 hours a day to conserve energy. Habitat destruction, disease, and climate change pose significant threats to koala populations. Conservation efforts focus on preserving eucalyptus forests and addressing threats like deforestation and climate impacts to protect their habitats."],
    ["leopard", "Leopards are large cats with a distinctive spotted coat and are known for their stealth and adaptability. They have a broad range across Africa and parts of Asia. Leopards are solitary hunters and are incredibly strong climbers, often dragging prey up trees to keep it safe from scavengers. They are highly adaptable, living in various habitats, including forests, grasslands, and deserts. Leopards face threats from habitat loss and hunting, but their adaptability has allowed some populations to coexist near human settlements."],
    ["cheetah", "Cheetahs are the fastest land animals, capable of reaching speeds up to 60-70 miles per hour in short bursts. Native to Africa and some parts of Iran, they are built for speed with lightweight frames, long legs, and large nasal passages. Unlike other big cats, cheetahs rely on speed over strength to catch prey. They are often solitary, with females raising cubs alone. Habitat loss and competition with larger predators have put cheetahs at risk, and conservation efforts aim to protect their shrinking habitats."],
    ["alligator", "Alligators are large reptiles primarily found in freshwater environments like swamps, rivers, and lakes in the southeastern United States and China. Known for their muscular bodies, powerful jaws, and sharp teeth, they are skilled hunters that ambush prey. Alligators have armored skin with tough, scaly hides that help protect them in the wild. They are cold-blooded and rely on the sun to regulate their body temperature, often basking on riverbanks. Alligators play a vital role in their ecosystems, maintaining population balance among species and creating wetland habitats beneficial for other wildlife."],
    ["giraffe", "Giraffes are the tallest land animals, standing up to 18 feet tall, and are native to the savannas of Africa. Their long necks and legs allow them to reach leaves high up in trees, especially acacias, which form a major part of their diet. Giraffes have unique coat patterns, which vary individually and help with camouflage. They live in loose social groups, and calves are cared for by mothers in 'nurseries' while adults forage. Giraffes face threats from habitat loss and poaching, and conservation efforts are essential to preserve these gentle giants and their role in African ecosystems."],
    ["ant", "Ants are small, social insects found almost everywhere on Earth, forming complex colonies with specialized roles such as workers, soldiers, and queens. Known for their strength, ants can lift several times their body weight. They communicate and coordinate with pheromones, creating efficient networks to locate food and protect the colony. Ants play a significant role in ecosystems by aerating soil, decomposing organic material, and controlling other insect populations. Despite their small size, ants are remarkable for their teamwork and adaptability to various environments."],
    ["bee", "Bees are vital pollinators and are essential to ecosystems and agriculture. Known for their distinctive black and yellow stripes, bees live in highly organized colonies led by a queen. They collect nectar and pollen from flowers, producing honey and aiding in plant reproduction. Bees have a strong sense of communication, using a 'waggle dance' to share information about food sources. Unfortunately, bees face threats from habitat loss, pesticides, and climate change, and conservation efforts aim to protect their populations and their critical pollination role."],
    ["butterfly", "Butterflies are delicate, colorful insects with two pairs of large, scaled wings that are often intricately patterned. They undergo a complete metamorphosis, transforming from caterpillars into adult butterflies through a chrysalis stage. Butterflies play a crucial role in pollination and are sensitive indicators of environmental health. They are found worldwide in various habitats, including forests, meadows, and gardens. Their striking patterns serve as camouflage or warning signals to predators, and many species migrate to breed in specific locations, like the Monarch butterfly."],
    ["spider", "Spiders are arachnids, known for their ability to spin webs from silk produced in their bodies. With eight legs and multiple eyes, spiders are diverse, inhabiting almost every habitat on Earth. They are predators, capturing prey in webs or hunting on the ground, and they help control insect populations. Some spiders have venomous bites to immobilize prey, though most are harmless to humans. Spiders contribute to biodiversity and are essential for ecological balance, yet they are often misunderstood or feared due to their appearance."],
    ["scorpion", "Scorpions are arachnids known for their distinctive pincers and segmented tails that end in a venomous stinger. Found in deserts, forests, and grasslands, scorpions are nocturnal predators that hunt insects and small animals. They use their pincers to capture prey and inject venom if threatened. Scorpions are resilient, surviving extreme conditions, and some species can even glow under ultraviolet light. While feared, only a few species pose a danger to humans. Scorpions play a valuable role in ecosystems by controlling insect populations."],
    ["crab", "Crabs are crustaceans with hard exoskeletons, ten legs, and pincers that they use for defense and handling food. Found in oceans, freshwater, and on land, crabs are omnivores that scavenge for food, contributing to nutrient recycling. They vary widely in size and appearance, from tiny pea crabs to large king crabs. Crabs are known for their sideways walk and can regenerate lost limbs. They are crucial for marine and coastal ecosystems, aiding in the balance of food webs and contributing to sediment turnover."],
    ["lobster", "Lobsters are marine crustaceans with hard shells, two large claws, and a segmented body. They live on the ocean floor and are known for their scavenging and predatory habits, feeding on fish, mollusks, and plant material. Lobsters have complex social behaviors, including territory marking, and can regenerate lost claws or legs. They play a role in marine ecosystems by recycling nutrients and controlling prey populations. Valued as a seafood delicacy, lobsters are economically important, with sustainable fishing practices necessary to maintain healthy populations."],
    ["jellyfish", "Jellyfish are ancient, gelatinous marine animals with bell-shaped bodies and tentacles. They drift with ocean currents and capture prey using tentacles lined with stinging cells. Jellyfish play an important role in marine food webs, both as predators and prey. They vary greatly in size, from tiny, nearly invisible species to large species with meters-long tentacles. Blooms of jellyfish can indicate ecosystem changes, often linked to warming waters. Some species are harmless, while others can deliver painful or even dangerous stings."],
    ["starfish", "Starfish, or sea stars, are marine invertebrates known for their star-shaped bodies. They have hundreds of tube-like feet on their undersides, allowing them to move and attach to surfaces. Starfish are found in oceans worldwide and are important to marine ecosystems, often feeding on mussels and barnacles, controlling these populations. They have remarkable regenerative abilities, sometimes regrowing lost arms. Starfish lack a centralized brain but have a nerve network that allows them to sense their surroundings and react to threats."],
    ["seahorse", "Seahorses are small, unique fish with horse-like heads and prehensile tails. Found in shallow, warm ocean waters, they cling to seagrasses and corals. Seahorses are poor swimmers, relying on camouflage to avoid predators. They are unusual because males carry fertilized eggs in a specialized pouch until they hatch. Seahorses contribute to biodiversity but face threats from habitat destruction, pollution, and overfishing. Conservation efforts aim to protect their habitats, which include coral reefs and seagrass beds."],
    ["manta ray", "Manta rays are large, graceful fish known for their wide, flat bodies and triangular pectoral fins, which they use to 'fly' through the water. Found in warm, tropical seas, they feed primarily on plankton and small fish by filtering water through their gills. Manta rays are often solitary but sometimes gather in groups. They play an important role in ocean ecosystems as nutrient cyclers. Unfortunately, manta rays are threatened by overfishing and habitat degradation, leading to conservation measures to protect their populations."],
    ["pufferfish", "Pufferfish are small to medium-sized fish known for their ability to 'puff' up by ingesting water or air, making them difficult for predators to swallow. They are found in warm, coastal waters and have a unique defense mechanism, as some species carry toxic compounds. Pufferfish are omnivores, feeding on invertebrates, algae, and small fish. While some pufferfish are prized as delicacies, they must be prepared carefully due to their potential toxicity. They contribute to the balance of marine ecosystems by controlling invertebrate populations."],
    ["salmon", "Salmon are migratory fish known for their complex life cycle and ability to adapt to both freshwater and saltwater. They are born in rivers, migrate to the ocean to mature, and return to their birthplace to spawn. Salmon are crucial to ecosystems, as their migration enriches nutrient-poor rivers and provides food for animals like bears and eagles. They are also economically significant, but overfishing, habitat loss, and climate change threaten wild populations, leading to the need for sustainable fishing practices and conservation efforts."],
    ["trout", "Trout are freshwater fish that thrive in clean, cold rivers and lakes. They are part of the salmon family and are known for their distinctive spotted patterns and streamlined bodies. Trout are important indicators of water quality, as they require well-oxygenated water to survive. They are popular among anglers and are also ecologically significant, as they help maintain a balanced ecosystem by preying on insects, smaller fish, and crustaceans. Conservation efforts aim to protect water quality and habitat for healthy trout populations."],
    ["catfish", "Catfish are bottom-dwelling freshwater fish known for their distinctive whisker-like barbels around the mouth. Found worldwide in various habitats, they are highly adaptable and can survive in low-oxygen environments. Catfish are omnivorous scavengers, feeding on plants, small fish, and detritus, which helps clean their ecosystems. Some species are farmed as a popular food source, while others are valued in sport fishing. Their hardy nature allows them to thrive in a variety of conditions, contributing to biodiversity and waterway health."],
    ["hedgehog", "Hedgehogs are small, spiny mammals found in Europe, Asia, and Africa. They are nocturnal and have a unique defense mechanism, rolling into a tight ball to protect themselves with their sharp spines. Hedgehogs are insectivores, feeding on insects, worms, and small vertebrates, helping control pest populations. They are also popular as pets, though they face threats in the wild from habitat loss and road mortality. Conservation efforts focus on habitat protection and public awareness about safe environments for these creatures."],
    ["raccoon", "Raccoons are medium-sized mammals native to North America, known for their 'masked' faces and dexterous front paws. They are highly adaptable omnivores, thriving in urban and forested areas, feeding on fruits, insects, small animals, and human food scraps. Raccoons are intelligent and resourceful, capable of opening containers and finding food in various ways. While they can be a nuisance in urban areas, they play an essential role in ecosystems by controlling insect populations and dispersing seeds."],
    ["falcon", "Falcons are birds of prey known for their speed, agility, and excellent eyesight. Found on every continent except Antarctica, falcons are skilled hunters, often diving at incredible speeds to catch smaller birds and mammals. They have sharp, hooked beaks for tearing flesh and streamlined bodies that help them fly swiftly through the air. Falcons play a role in ecosystems by controlling populations of smaller animals, and certain species, like the peregrine falcon, have made remarkable comebacks through conservation efforts after being endangered by pesticide use."],
    ["hawk", "Hawks are medium-sized birds of prey found worldwide in forests, grasslands, and urban areas. Known for their sharp talons and keen vision, they hunt small mammals, birds, and reptiles. Hawks are solitary hunters and use their powerful wings to soar at great heights while searching for prey. They play a crucial ecological role by managing the populations of smaller animals. Hawks are highly adaptable and can even thrive in urban environments, making them a common sight in cities and countryside alike."],
    ["owl", "Owls are nocturnal birds of prey recognized for their large eyes, round faces, and silent flight. They have exceptional night vision and acute hearing, allowing them to hunt in low-light conditions. Owls prey on small mammals, birds, and insects, contributing to pest control in various ecosystems. Owls have specialized feathers that enable silent flight, helping them approach prey undetected. They are found in diverse habitats worldwide, from forests to deserts, and are often symbols of wisdom in many cultures."],
    ["peacock", "Peacocks are colorful birds native to South Asia, known for the iridescent, fan-like tail feathers displayed by males during courtship. These long, eye-patterned feathers create a stunning visual display that attracts mates and deters predators. Peacocks are part of the pheasant family and primarily forage on the ground, eating seeds, insects, and small animals. They are culturally significant in many regions and have been domesticated in various parts of the world. Their brilliant displays make them iconic and beloved animals."],
    ["flamingo", "Flamingos are wading birds known for their long, thin legs and distinctive pink feathers. Native to regions with saline or alkaline water bodies, they feed by filtering algae and small invertebrates from the water. Their pink color comes from the carotenoids in their diet. Flamingos are highly social, forming large colonies for feeding and nesting. They play an important role in their ecosystems by contributing to nutrient cycling in shallow lakes and wetlands. Conservation efforts are focused on protecting their wetland habitats from human impact."],
    ["parrot", "Parrots are colorful, intelligent birds known for their vocal abilities and strong beaks. Found in tropical and subtropical regions, they are highly social and form strong bonds with their flock mates. Parrots eat a diet of seeds, fruits, and nuts, which they can crack open with their powerful beaks. Some species mimic human speech and other sounds. Parrots play a key role in seed dispersal, aiding in forest regeneration. Many parrot species are threatened by habitat loss and capture for the pet trade, making conservation efforts vital."],
    ["eagle", "Eagles are large birds of prey known for their powerful build, sharp beak, and keen eyesight, allowing them to spot prey from great distances. Found on every continent except Antarctica, they inhabit a range of environments from mountains to forests and coastal regions. Eagles are apex predators, feeding on fish, small mammals, and occasionally other birds. They are solitary hunters and build enormous nests, often high in trees or on cliffs. As symbols of strength and freedom, eagles are admired worldwide. Conservation efforts focus on protecting their habitats and mitigating threats like pollution and habitat destruction."],
]);


let menu = document.getElementById("selection_menu");
let guess_input = document.getElementById("search");
let result = document.getElementById("result");
let info = document.getElementById("info");
let info_title = document.getElementById("animal_name");
let animal_img = document.getElementById("animal_image");
let current_selected = -1;
let possible_options = [];

guess_input.addEventListener("input", (e) => populateMenu());
document.getElementById("submit").addEventListener("click", (e) => {e.preventDefault(); showResult(guess_input.value);})

showResult("alligator");

addEventListener("keydown", (event) => {
    if(current_selected>=0 && possible_options.length>0)
    {
        menu.children[current_selected].classList.remove("selected");
    }

    if(event.key == "ArrowUp")
    {
        event.preventDefault();
        if(current_selected > 0)
        {
            current_selected--;
        }
    }
    else if(event.key == "ArrowDown")
    {
        event.preventDefault();
        if(current_selected < possible_options.length-1)
        {
            current_selected++;
        }
    }
    else if(event.key == "Enter")
    {
        if(current_selected>=0 && possible_options.length>0)
        {
            guess_input.value = possible_options[current_selected];
            menu.innerHTML = '';
            showResult(guess_input.value);
            current_selected = -1;
        }
    }

    if(current_selected>=0 && possible_options.length>0)
    {
        menu.children[current_selected].classList.add("selected");
    }
    //console.log(current_selected);
});

function populateMenu() {
    menu.innerHTML = '';
    if(guess_input.value == '')
    {
        possible_options = [];
        return
    }

    possible_options = Array.from(animals.keys().filter(element => element.startsWith(guess_input.value.toLowerCase())));
    possible_options.forEach(element => {
        let option = document.createElement('a');
        let list_elemnt = document.createElement('li');
        option.innerHTML = element;
        option.addEventListener("click", (e) => {
            guess_input.value = element;
            menu.innerHTML = '';
            showResult(guess_input.value);
            console.log(logAnimations(list_elemnt));
        })
        list_elemnt.appendChild(option);
        menu.appendChild(list_elemnt);
    });
    current_selected = -1;

}

function showResult(animal) {
    info_title.innerHTML = String(animal).charAt(0).toUpperCase() + String(animal).slice(1);
    info.innerHTML = "";

    animals.get(animal).split(" ").forEach((e,i) => {
        const item = document.createElement("span");
        item.classList.add("fade-in-item");
        item.classList.add("word");

        item.textContent = `${e} `;

        item.style.animationDelay = `${i * 0.03}s`;
        info.appendChild(item);
    });

    animal_img.classList.remove("fade-in-item");
    //force update
    void animal_img.offsetWidth;
    animal_img.classList.add("fade-in-item");
    animal_img.setAttribute("src", `imgs/${animal}.jpg`);
}
