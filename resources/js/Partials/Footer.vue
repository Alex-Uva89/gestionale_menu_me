
<template>
    <footer class="h-28 w-full bottom-0 left-5 p-5 text-sm text-black dark:text-white/70 border-t-2 border-black">
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

