<template>
    <nav>
        <ul class="pager">
            <li class="previous {{isOnFirstPage ? disabledClass : ''}}">
                <a href="#" @click="loadPage('prev')"><i class="glyphicon glyphicon-chevron-left"></i>Previous</a>
            </li>           
            <li class="next {{isOnLastPage ? disabledClass : ''}}">
                <a href="#" @click="loadPage('next')"><i class="glyphicon glyphicon-chevron-right"></i>Next</a>
            </li>
        </ul>
    </nav>
</template>

<script>
var PaginationMixin = require('vuetable/src/components/VuetablePaginationMixin.vue')

export default {
    mixins: [PaginationMixin],
    methods: {
        loadPage: function(page) {
            event.preventDefault()
            this.$dispatch('vuetable-pagination:change-page', page)
        },
    },
}
</script>