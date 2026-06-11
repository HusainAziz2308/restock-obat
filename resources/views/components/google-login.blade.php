<div style="margin-top: 1rem;">
    <x-filament::button 
        href="{{ route('auth.google') }}" 
        tag="a" 
        color="gray" 
        style="width: 100%;"
    >
        <div style="display: flex; align-items: center; justify-content: center; gap: 0.5rem; width: 100%;">
            <img src="https://www.svgrepo.com/show/475656/google-color.svg" style="width: 20px; height: 20px;" alt="Google Logo">
            <span>Lanjutkan dengan Google</span>
        </div>
    </x-filament::button>
</div>