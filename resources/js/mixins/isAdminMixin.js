export default {
    computed: {
        isAdmin() {
            return this.user?.roles.some(role => role.name === 'admin');
        }
    }
}
