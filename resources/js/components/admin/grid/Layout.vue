<template>
    <div class="row">
        <div class="col-lg-12">
            <div class="card" :id="id">
                <div class="card-header">
                    <h1 class="float-left mb-0 pt-2 pb-2 font-xl">{{ title }}</h1>

                    <div class="float-right">
                        <slot name="button"></slot>
                    </div>
                </div>

                <div class="card-body">
                    <slot name="body"></slot>
                </div>

                <div class="card-footer">
                    <slot name="footer"></slot>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    export default {
        name: 'AdminLayout',
        props: {
            title: String,
            id: String
        }
    }
</script>
