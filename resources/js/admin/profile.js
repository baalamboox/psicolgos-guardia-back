const profile = () => {
    return {
        profileSource: '/img/profile/default.jpg',
        changeProfile(event) {
            this.profileSource = URL.createObjectURL(event.target.files[0]);
        }
    };
};

export { profile };
