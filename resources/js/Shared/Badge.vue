<template>
    <span :class="badgeClass(channelId, color)"
        class="inline-flex uppercase items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium border-[1px] ">
        {{ title }}
    </span>
</template>

<script>
export default {
    props: ['title', 'channelId', 'color'],
    methods: {
        badgeClass(channelId, color) {
            const colors = {
                1: 'border-blue-500 bg-blue-50 text-blue-800',
                3: 'border-green-500 bg-green-50 text-green-800',
                4: 'border-yellow-500 bg-yellow-50 text-yellow-800',
                5: 'border-indigo-500 bg-indigo-50 text-indigo-800',
                6: 'border-pink-500 bg-pink-50 text-pink-800',
                7: 'border-purple-500 bg-purple-50 text-purple-800',
                8: 'border-gray-500 bg-gray-50 text-gray-800',
                9: 'border-red-500 bg-red-50 text-red-800',
                10: 'border-teal-500 bg-teal-50 text-teal-800',
                11: 'border-orange-500 bg-orange-50 text-orange-800',
                12: 'border-cyan-500 bg-cyan-50 text-cyan-800',
                13: 'border-rose-500 bg-rose-50 text-rose-800',
                14: 'border-emerald-500 bg-emerald-50 text-emerald-800',
                15: 'border-violet-500 bg-violet-50 text-violet-800',
                16: 'border-amber-500 bg-amber-50 text-amber-800',
                17: 'border-fuchsia-500 bg-fuchsia-50 text-fuchsia-800',
                18: 'border-lime-500 bg-lime-50 text-lime-800',
                19: 'border-sky-500 bg-sky-50 text-sky-800',
            }
            if (color) {
                return `border-${color}-500 bg-${color}-50 text-${color}-800`;
            }
            const colorKeys = Object.keys(colors);
            const id = Number(channelId);
            if (isNaN(id)) {
                return 'bg-red-100 text-gray-800';
            }
            const colorKey = colorKeys[id % colorKeys.length];
            return colors[colorKey];

        },
    }
}
</script>
