<template>
    <v-menu :close-on-content-click="false" location="end">
        <template v-slot:activator="{ props }">
            <v-btn v-bind="props" class="!p-0 !shadow-red-600">
                <TableIcon />tBWL
            </v-btn>
        </template>

        <v-container min-width="200" max-width="220">
            <div>
                <v-row v-for="(row, rowIndex) in buttons" :key="'row-' + rowIndex">
                    <v-col v-for="(button, buttonIndex) in row" :key="'button-' + buttonIndex" cols="1" sm="2">
                        <tooltip-btn :tooltipText="button.text" :icon="button.icon" :actionType="button.action"
                            :editor="editor" />
                    </v-col>
                </v-row>
            </div>
        </v-container>
    </v-menu>
</template>

<script>
import TableIcon from 'vue-material-design-icons/Table.vue'


export default {
    components: {
        TableIcon
    },
    props: ['buttons', 'editor']
};
</script>
