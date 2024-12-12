window.Echo.private("delivery").listen("PackageSent", (event) => {
    console.log("ahoy");
    console.log(event.data);
});

window.Echo.private(`rooms.1`)
    .listen('UserJoined', (e) => {
        console.log("joined");
        console.log(e);
});

console.log(@json($room))
