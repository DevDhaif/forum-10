<template>
    <v-menu :close-on-content-click="false" location="end">
        <template v-slot:activator="{ props }">
            <v-btn v-on="props.on" v-bind="props" class="!p-0 !shadow-red-600">
                <TableIcon />
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

<script setup>
import { getButtons } from '../../data/editorButtons'
import TableIcon from 'vue-material-design-icons/Table.vue'
const props = defineProps({ editor: Object })
const buttons = getButtons(props.editor);

</script>../../data/editorButtons
