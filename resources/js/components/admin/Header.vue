<template>
    <header class="c-header c-header-fixed">
        <button type="button" class="c-header-toggler c-class-toggler mfs-3" data-target="#sidebar"
                data-class="c-sidebar-lg-show" responsive="true">
            <i class="cil-menu"></i>
        </button>

        <ul class="c-header-nav mfs-auto mfe-md-3">
            <li class="c-header-nav-item">
                <a :href="Helper.urlFormat('/logout')" class="c-header-nav-link">logout</a>
            </li>
        </ul>
    </header>
</template>

<script>
    export default {
        name: 'AdminHeader'
    }
</script>
