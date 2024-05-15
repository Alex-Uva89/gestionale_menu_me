
<template>
    <footer class="fixed bottom-0 left-5 py-5 text-sm text-black dark:text-white/70">
        <div>
            &copy; {{ new Date().getFullYear() }} MammaElvira
        </div>
       <div>
        MammaElvira v.{{ $page.props.projectVersion }}
        </div>
       <div>
        dev with Laravel v.{{ $page.props.laravelVersion }}
       </div>
    </footer>
</template>

