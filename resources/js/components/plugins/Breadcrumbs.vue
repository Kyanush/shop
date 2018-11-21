<template>
    <section class="content-header">
        <h1>
            <span>{{ routeName }}</span>
        </h1>
        <ol class="breadcrumb">
            <li v-for="(breadcrumb, idx) in breadcrumbList" :key="idx" :class="{'linked': !!breadcrumb.link}">
                <a @click="routeTo(idx)" v-if="breadcrumb.link">
                    {{ breadcrumb.name }}
                </a>
            </li>
            <li>
                <a class="active">
                    {{ routeName }}
                </a>
            </li>
        </ol>
    </section>
</template>

<script>
    export default {
        name: 'Breadcrumb',
        data () {
            return {
                breadcrumbList: []
            }
        },
        mounted () { this.updateList() },
        watch: { '$route' () { this.updateList() } },
        methods: {
            routeTo (pRouteTo) {
                if (this.breadcrumbList[pRouteTo].link)
                    this.$router.push(this.breadcrumbList[pRouteTo].link)
            },
            updateList () {
                this.breadcrumbList = this.$route.meta.breadcrumb;
            }
        },
        computed:{
            routeName(){
                return this.$route.name;
            }
        }
    }
</script>

<style scoped>
    a:not(.active){
        cursor: pointer;
    }
    a:not(.active){
        text-decoration: underline!important;
    }
</style>