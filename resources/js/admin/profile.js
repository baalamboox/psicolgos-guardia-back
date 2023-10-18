const profile = () => {
    return {
        profileSource: 'https://source.unsplash.com/MP0IUfwrn0A',
        changeProfile(event) {
            this.profileSource = URL.createObjectURL(event.target.files[0]);
        }
    };
};

export { profile };
