@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <h2 class="card-title text-2xl mb-6">Settings</h2>

                <!-- Username Update Form -->
                <form id="update-username" class="mb-8">
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Change Username</span>
                        </label>
                        <div class="join">
                            <input type="text" name="name" class="input input-bordered join-item w-full" value="{{ Auth::user()->name }}" />
                            <button type="submit" class="btn btn-primary join-item">Update</button>
                        </div>
                    </div>
                </form>

                <!-- Theme Selection -->
                <div class="form-control mb-8">
                    <label class="label">
                        <span class="label-text">Theme Preference</span>
                    </label>
                    <select class="select select-bordered" id="theme-select" onchange="updateTheme(this.value)">
                        <option value="light">Light</option>
                        <option value="dark">Dark</option>
                        <option value="cupcake">Cupcake</option>
                        <option value="bumblebee">Bumblebee</option>
                        <option value="emerald">Emerald</option>
                        <option value="corporate">Corporate</option>
                        <option value="synthwave">Synthwave</option>
                        <option value="retro">Retro</option>
                        <option value="cyberpunk">Cyberpunk</option>
                        <option value="valentine">Valentine</option>
                        <option value="halloween">Halloween</option>
                        <option value="garden">Garden</option>
                        <option value="forest">Forest</option>
                        <option value="aqua">Aqua</option>
                        <option value="lofi">Lo-Fi</option>
                        <option value="pastel">Pastel</option>
                        <option value="fantasy">Fantasy</option>
                        <option value="wireframe">Wireframe</option>
                        <option value="black">Black</option>
                        <option value="luxury">Luxury</option>
                        <option value="dracula">Dracula</option>
                        <option value="cmyk">CMYK</option>
                        <option value="autumn">Autumn</option>
                        <option value="business">Business</option>
                        <option value="acid">Acid</option>
                        <option value="lemonade">Lemonade</option>
                        <option value="night">Night</option>
                        <option value="coffee">Coffee</option>
                        <option value="winter">Winter</option>
                    </select>
                </div>

                <!-- Delete Account -->
                <div class="divider">Danger Zone</div>
                <div class="bg-error/10 rounded-lg p-4">
                    <h3 class="text-lg font-semibold text-error mb-2">Delete Account</h3>
                    <p class="text-sm mb-4">Once you delete your account, there is no going back. Please be certain.</p>
                    <button onclick="confirmDelete()" class="btn btn-error">Delete Account</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function updateTheme(theme) {
    document.querySelector('html').setAttribute('data-theme', theme);
    localStorage.setItem('theme', theme);
}

document.getElementById('update-username').addEventListener('submit', function(e) {
    e.preventDefault();
    const name = this.querySelector('input[name="name"]').value;

    fetch('/settings/username', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        },
        body: JSON.stringify({ name })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    });
});

function confirmDelete() {
    if (confirm('Are you sure you want to delete your account? This action cannot be undone.')) {
        fetch('/settings/delete-account', {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                window.location.href = '/';
            }
        });
    }
}

// Set initial theme value
document.addEventListener('DOMContentLoaded', function() {
    const currentTheme = localStorage.getItem('theme') || 'light';
    document.getElementById('theme-select').value = currentTheme;
});
</script>
@endsection
