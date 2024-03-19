<template>
    <section v-if="editor"
            class="flex flex-wrap items-center p-4 text-gray-700 border-t border-l border-r border-gray-400 buttons gap-x-4">
            <input type="file" ref="fileInput" @change="handleFileUpload" hidden />
            <button v-for="itemButton in basicButtons" :key="itemButton.action" type="button"
                @click="itemButton.action(editor)"
                :class="typeof itemButton.class === 'function' ? itemButton.class() : ''" class="p-1">
                <component :is="itemButton.icon" />
            </button>
            <v-menu :close-on-content-click="false" location="end">
                <template v-slot:activator="{ props }">
                    <v-btn v-bind="props" class="!p-0 !shadow-red-600">
                        <TableIcon />
                    </v-btn>
                </template>

                <v-container min-width="200" max-width="220">
                    <div>
                        <v-row v-for="(row, rowIndex) in buttons" :key="'row-' + rowIndex">
                            <v-col v-for="(button, buttonIndex) in row" :key="'button-' + buttonIndex" cols="1" sm="2">
                                <TooltipBtnVue :tooltipText="button.text" :icon="button.icon"
                                    :actionType="button.action" :editor="editor" />
                            </v-col>
                        </v-row>
                    </div>
                </v-container>
            </v-menu>
        </section>
</template>
<script setup>
import { ref } from 'vue'
import TableIcon from 'vue-material-design-icons/Table.vue'
import TooltipBtnVue from './TooltipBtn.vue'
import { getBasicButtons, getButtons } from '../data/editorButtons'

const props = defineProps({
  editor: Object,
  handleFileUpload: Function
})
const fileInput = ref(null)

const basicButtons = getBasicButtons(props.editor,fileInput)
const buttons = getButtons(props.editor)
</script>
<style scoped lang="scss">
:deep(.tiptap) {
    table {
        border-collapse: collapse;
        margin: 0;
        overflow: hidden;
        table-layout: fixed;
        width: 100%;

        td,
        th {
            border: 2px solid #ced4da;
            box-sizing: border-box;
            min-width: 1em;
            padding: 3px 5px;
            position: relative;
            vertical-align: top;

            >* {
                margin-bottom: 0;
            }
        }

        th {
            background-color: #f1f3f5;
            font-weight: bold;
            text-align: left;
        }

        .selectedCell:after {
            background: rgba(200, 200, 255, 0.4);
            content: "";
            left: 0;
            right: 0;
            top: 0;
            bottom: 0;
            pointer-events: none;
            position: absolute;
            z-index: 2;
        }

        .column-resize-handle {
            background-color: #adf;
            bottom: -2px;
            position: absolute;
            right: -2px;
            pointer-events: none;
            top: 0;
            width: 4px;
        }

        p {
            margin: 0;
        }
    }
}

.tableWrapper {
    padding: 1rem 0;
    overflow-x: auto;
}

.resize-cursor {
    cursor: ew-resize;
    cursor: col-resize;
}

.v-btn {
    box-shadow: none !important;

    :hover {
        box-shadow: none !important;
    }
}
// .buttons {
//   button {
//     background-color: #f5f5f5;
//     border: 1px solid #e0e0e0;
//     border-radius: 4px;
//     color: #333;
//     cursor: pointer;
//     font-size: 1.5rem;
//     padding: 0.5rem;
//   }
// }
</style>
