import { computed } from 'vue'
import BoldIcon from 'vue-material-design-icons/FormatBold.vue'
import ItalicIcon from 'vue-material-design-icons/FormatItalic.vue'
import UnderlineIcon from 'vue-material-design-icons/FormatUnderline.vue'
import H1Icon from 'vue-material-design-icons/FormatHeader1.vue'
import H2Icon from 'vue-material-design-icons/FormatHeader2.vue'
import ListIcon from 'vue-material-design-icons/FormatListBulleted.vue'
import OrderedListIcon from 'vue-material-design-icons/FormatListNumbered.vue'
import BlockquoteIcon from 'vue-material-design-icons/FormatQuoteClose.vue'
import HorizontalRuleIcon from 'vue-material-design-icons/Minus.vue'
import UndoIcon from 'vue-material-design-icons/Undo.vue'
import RedoIcon from 'vue-material-design-icons/Redo.vue'
import ImageIcon from 'vue-material-design-icons/Image.vue'
import CodeBlockIcon from 'vue-material-design-icons/CodeBlockTags.vue'

export function getBasicButtons(editor, fileInput) {
    return computed(() => [
        {
            action: (editor) => editor && editor.chain().focus().toggleBold().run(),
            class: () => editor && editor.value.isActive('bold') ? 'bg-gray-200 rounded' : '',
            icon: BoldIcon,
            title: 'Bold'
        },
        {
            action: (editor) => editor && editor.chain().focus().toggleItalic().run(),
            class: () => editor && editor.value.isActive('italic') ? 'bg-gray-200 rounded' : '',
            icon: ItalicIcon,
            title: 'Italic'
        },
        {
            action: (editor) => editor && editor.chain().focus().toggleUnderline().run(),
            class: () => editor && editor.value.isActive('underline') ? 'bg-gray-200 rounded' : '',
            icon: UnderlineIcon,
            title: 'Underline'
        },
        {
            action: (editor) => editor && editor.chain().focus().toggleHeading({ level: 1 }).run(),
            class: () => editor && editor.value.isActive('heading', { level: 1 }) ? 'bg-gray-200 rounded' : '',
            icon: H1Icon,
            title: 'H1'
        },
        {
            action: (editor) => editor && editor.chain().focus().toggleHeading({ level: 2 }).run(),
            class: () => editor && editor.value.isActive('heading', { level: 2 }) ? 'bg-gray-200 rounded' : '',
            icon: H2Icon,
            title: 'H2'
        },
        {
            action: (editor) => editor && editor.chain().focus().toggleBulletList().run(),
            class: () => editor && editor.value.isActive('bulletList') ? 'bg-gray-200 rounded' : '',
            icon: ListIcon,
            title: 'Bullet List'
        },
        {
            action: (editor) => editor && editor.chain().focus().toggleOrderedList().run(),
            class: () => editor && editor.value.isActive('orderedList') ? 'bg-gray-200 rounded' : '',
            icon: OrderedListIcon,
            title: 'Ordered List'
        },
        {
            action: (editor) => editor && editor.chain().focus().toggleBlockquote().run(),
            class: () => editor && editor.value.isActive('blockquote') ? 'bg-gray-200 rounded' : '',
            icon: BlockquoteIcon,
            title: 'Blockquote'
        },
        {
            action: (editor) => editor && editor.chain().focus().toggleCodeBlock().run(),
            class: () => editor && editor.value.isActive('codeBlock') ? 'bg-gray-200 rounded' : '',
            icon: CodeBlockIcon,
            title: 'Code'
        },
        {
            action: (editor) => editor && editor.chain().focus().setHorizontalRule().run(),
            icon: HorizontalRuleIcon,
            title: 'Horizontal Rule'
        },
        {
            action: () => fileInput.value.click(),
            icon: ImageIcon,
            title: 'Image'
        },
        {
            action: (editor) => editor && editor.chain().focus().undo().run(),
            class: () => editor && !editor.value.can().undo() ? 'text-gray-400' : '',
            icon: UndoIcon,
            title: 'Undo'
        },
        {
            action: (editor) => editor && editor.chain().focus().redo().run(),
            class: () => editor && !editor.value.can().redo() ? 'text-gray-400' : '',
            icon: RedoIcon,
            title: 'Redo'
        },
    ])
}
;
export function getButtons(editor) {
    return [
        [
            {
                text: 'Add Table',
                icon: 'mdi-table-plus',
                action: (editor) => editor.chain().focus().insertTable({ rows: 3, cols: 3 }).run()
            },
            {
                text: 'Add Column Berfore',
                icon: 'mdi-table-column-plus-before',
                action: (editor) => editor.chain().focus().addColumnBefore().run()
            },
            {
                text: 'Add Row Berfore',
                icon: 'mdi-table-row-plus-before',
                action: (editor) => editor.chain().focus().addRowBefore().run()
            },
            {
                text: 'Remove Column',
                icon: 'mdi-table-column-remove',
                action: (editor) => editor.chain().focus().deleteColumn().run()
            },
            {
                text: 'Remove Row',
                icon: 'mdi-table-row-remove',
                action: (editor) => editor.chain().focus().deleteRow().run()
            },
        ],
        [
            {
                text: 'Remove Table',
                icon: 'mdi-table-remove',
                action: (editor) => editor.chain().focus().deleteTable({ rows: 3, cols: 3 }).run()
            },
            {
                text: 'Add Column After',
                icon: 'mdi-table-column-plus-after',
                action: (editor) => editor.chain().focus().addColumnAfter().run()
            },
            {
                text: 'Add Row Berfore',
                icon: 'mdi-table-row-plus-after',
                action: (editor) => editor.chain().focus().addRowAfter().run()
            },
            {
                text: 'Merge Cells',
                icon: 'mdi-table-merge-cells',
                action: (editor) => editor.chain().focus().mergeCells().run()
            },
            {
                text: 'Split Cells',
                icon: 'mdi-table-split-cell',
                action: (editor) => editor.chain().focus().splitCell().run()
            },
        ],

        [
            {
                text: 'Toggle Column Header',
                icon: 'mdi-table-column',
                action: (editor) => editor.chain().focus().toggleHeaderColumn().run()
            },
            {
                text: 'Toggle Row Header',
                icon: 'mdi-table-row',
                action: (editor) => editor.chain().focus().toggleHeaderRow().run()
            },
            {
                text: 'Toggle Header Cell',
                icon: 'mdi-table-headers-eye',
                action: (editor) => editor.chain().focus().toggleHeaderCell().run()
            },
            {
                text: 'Col Span 2',
                icon: 'mdi-table-column-width',
                action: (editor) => editor.chain().focus().setCellAttribute('colspan', 2).run()
            }
        ]
    ]
}
