<template>
  <div class="space-y-4">
    <div class="flex items-center justify-between w-full py-4 mt-4">
      <div>
        <Link :href="thread.path" class="flex-1 text-sm text-blue-600">
          {{ thread.title }}
        </Link>
        <Link
          :href="'threads/' + thread.channel.slug"
          class="px-4 text-red-500"
        >
          {{ thread.channel.name || '' }}
        </Link>
      </div>
      <p class="text-sm text-gray-600">
        Published {{ formatDate(thread.created_at) }} by
        <Link :href="thread.creator.path" class="text-sm text-blue-600">
          {{ thread.creator.name }}
        </Link>
        and has {{ thread.replies_count }}
        {{ thread.replies_count > 1 ? 'replies' : 'reply' }}.
      </p>
    </div>
    <div class="mt-6">
      <div v-html="truncatedBody"></div>
      <Link
        v-if="thread.body.length > 100"
        :href="thread.path"
        class="text-sm text-blue-600"
      >
        Read more
      </Link>
    </div>
  </div>
</template>
<script>
import { Link } from '@inertiajs/inertia-vue3'
import moment from 'moment'
import { highlightCode } from '../Utils/highlightCode.js'

export default {
  components: {
    Link,
  },
  props: {
    thread: Object,
    channel: String,
  },
  computed: {
    formatDate() {
      return date => moment(date).fromNow()
    },
    mounted() {
      this.$nextTick(() => {
        const blocks = this.$el.querySelectorAll('pre code')
        blocks.forEach(block => {
          this.$hljs.highlightBlock(block)
        })
      })
    },
    truncatedBody() {
      let body = this.thread.body
      if (body.length > 100) {
        body = body.substring(0, 100) + '...'
      }
      return highlightCode(body)
    },
  },
}
</script>
