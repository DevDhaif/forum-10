<template>
  <div>
    <div class="mb-4">
      <Link class="flex items-center py-3 group" href="/">
      <icon name="dashboard" class="w-4 h-4 mr-2"
        :class="isUrl('') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
      <div :class="isUrl('') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Dashboard</div>
      </Link>
    </div>
    <div class="mb-4">
      <Link class="flex items-center py-3 group" href="/threads">
      <icon name="thread" class="w-4 h-4 mr-2"
        :class="isUrl('threads') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
      <div :class="isUrl('threads') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">threads</div>
      </Link>
    </div>
  </div>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue3'
import Icon from '@/Shared/Icon'
import Dropdown from '@/Shared/Dropdown'


export default {
  components: {
    Icon,
    Link,
    Dropdown
  },
  methods: {
    isUrl(...urls) {
      let currentUrl = this.$page.url.substr(1)
      if (urls[0] === '') {
        return currentUrl === ''
      }
      return urls.filter((url) => currentUrl.startsWith(url)).length
    },
  },
}
</script>
