<script setup>
import { useEditor, EditorContent } from '@tiptap/vue-3'
import StarterKit from '@tiptap/starter-kit'
import Underline from '@tiptap/extension-underline'
import ImageResize from 'tiptap-extension-resize-image'
import { Table } from '@tiptap/extension-table'
import { TableRow } from '@tiptap/extension-table-row'
import { TableHeader } from '@tiptap/extension-table-header'
import { TableCell } from '@tiptap/extension-table-cell'
import CodeBlockLowlight from '@tiptap/extension-code-block-lowlight'
import TextDirection from "tiptap-text-direction";
import { getBasicButtons, getButtons } from '../../data/editorButtons'
import { ref } from 'vue'
import lowlight from '../../data/highlightLanguages'
import axios from 'axios'
import TableIcon from 'vue-material-design-icons/Table.vue'
import TooltipBtnVue from './TooltipBtn.vue'

const props = defineProps({ modelValue: String })
const editor = useEditor({
    content: props.modelValue,
    onUpdate: ({ editor }) => {
        emit('update:modelValue', editor.getHTML())
    },
    extensions: [
        StarterKit,
        Underline,
        ImageResize,
        TableRow,
        TableHeader,
        TableCell,
        Table.configure({ resizable: true }),
        CodeBlockLowlight.configure({ lowlight }),
        TextDirection.configure({
            types: ["heading", "paragraph"],
        }),
    ],
    editorProps: {
        attributes: {
            class:
                ' min-h-[28rem] max-h-[12rem] prose dark:prose-invert  p-4 overflow-y-auto outline-none  max-w-none border-[1px] border-slate-500 dark:border-slate-600',
        },
    },
})

const emit = defineEmits(['update:modelValue'])

const fileInput = ref(null)

const basicButtons = getBasicButtons(editor, fileInput)
const buttons = getButtons(editor)

const handleFileUpload = event => {
    const file = event.target.files[0]
    const formData = new FormData()
    formData.append('image', file)

    axios
        .post('/upload-image', formData)
        .then(response => {
            const imageUrl = response.data.url
            editor.value.chain().focus().setImage({ src: imageUrl }).run()
        })
        .catch(error => {
            console.error('Error:', error)
        })
}
</script>

<template>
    <div class="prose-code:prose-code-lg">
        <section v-if="editor"
            class="flex flex-wrap items-center p-4 text-gray-700 border-t-[1px] border-l border-r border-slate-400 dark:border-slate-600 buttons gap-x-4">
            <input type="file" ref="fileInput" @change="handleFileUpload" hidden />
            <button v-for="itemButton in basicButtons" :key="itemButton.action" type="button"
                @click="itemButton.action(editor)"
                :class="typeof itemButton.class === 'function' ? itemButton.class() : ''" class="p-1">
                <component :is="itemButton.icon" />
            </button>
            <v-menu :close-on-content-click="false" location="end">
                <template v-slot:activator="{ props }">
                    <v-btn v-bind="props" class="!p-0 !bg-transparent ">
                        <TableIcon class="text-gray-700 " />
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

        <EditorContent :editor="editor" />
    </div>
</template>
<style scoped lang="scss">
:deep(.bg-gray-200) {
    background-color: #edf2f7;
}

:deep(.rounded) {
    border-radius: 0.375rem;
}

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
            content: '';
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

.ProseMirror p[dir="rtl"],
.ProseMirror h1[dir="rtl"],
.ProseMirror h2[dir="rtl"],
.ProseMirror h3[dir="rtl"],
.ProseMirror h4[dir="rtl"],
.ProseMirror h5[dir="rtl"],
.ProseMirror h6[dir="rtl"] {
    text-align: right;
}

.ProseMirror p[dir="ltr"],
.ProseMirror h1[dir="ltr"],
.ProseMirror h2[dir="ltr"],
.ProseMirror h3[dir="ltr"],
.ProseMirror h4[dir="ltr"],
.ProseMirror h5[dir="ltr"],
.ProseMirror h6[dir="ltr"] {
    text-align: left;
}
</style>
