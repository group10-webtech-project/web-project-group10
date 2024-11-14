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
]);


let menu = document.getElementById("selection_menu");
let guess_input = document.getElementById("search");
let result = document.getElementById("result");
let info = document.getElementById("info");
let info_title = document.getElementById("animal_name");
let animal_img = document.getElementById("animal_image");

guess_input.addEventListener("input", (e) => populateMenu());
document.getElementById("submit").addEventListener("click", (e) => {e.preventDefault(); showResult(guess_input.value);})

showResult("alligator");

function populateMenu() {
    menu.innerHTML = '';
    if(guess_input.value == '')
    {
        return
    }

    const possible_options = animals.keys().filter(element => element.startsWith(guess_input.value.toLowerCase()));
    possible_options.forEach(element => {
        let option = document.createElement('a');
        let list_elemnt = document.createElement('li');
        //option.classList.add("item");
        option.innerHTML = element;
        option.addEventListener("click", (e) => {
            guess_input.value = element;
            menu.innerHTML = '';
        })
        list_elemnt.appendChild(option);
        menu.appendChild(list_elemnt);
    });

}

function showResult(animal) {
    info_title.innerHTML = animal;
    info.innerHTML = animals.get(animal);
    animal_img.setAttribute("src", `imgs/${animal}.jpg`);
}
