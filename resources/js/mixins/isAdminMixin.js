export default {
    computed: {
        isAdmin() {
            return this.user?.role === 'admin';
        }
    }
}
