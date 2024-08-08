import takeQuest from './api/takeQuest'
import checkInStartSiteQuest from './api/checkInStartSiteQuest'
import checkInWorkingSiteQuest from './api/checkInWorkingSiteQuest'

export default (site_quest) => ({
    site_quest,
    is_checking_quest: false,
    is_taking_quest: false,
    loaded_images: [],

    async takeQuest(event) {
        event.preventDefault();

        const form = this.$refs.takeQuestForm
        const formData = new FormData(form);

        this.is_taking_quest = true
        await takeQuest(formData).then(data => {
            if(!data) return;
            toast('success', data.msg);
            this.$dispatch('updated-player-site-quest', data.player_site_quest);
        }).finally(() => {
            this.is_taking_quest = false;
        })
    },

    async checkInStartSiteQuest(event) {
        event.preventDefault();

        const form = this.$refs.checkInStartSiteQuest
        const formData = new FormData(form);

        this.is_checking_quest = true
        await checkInStartSiteQuest(formData).then(data => {
            if(!data) return;
            toast('success', data.msg);
            this.$dispatch('updated-player-site-quest', data.player_site_quest);
        }).finally(() => {
            this.is_checking_quest = false;
        })
    },

    async checkInWorkingSiteQuest(event) {
        event.preventDefault();

        const form = this.$refs.checkInWorkingSiteQuest
        const formData = new FormData(form);

        this.is_checking_quest = true
        await checkInWorkingSiteQuest(formData).then(data => {
            if(!data) return;
            toast('success', data.msg);
            this.$dispatch('updated-player-site-quest', data.player_site_quest);
        }).finally(() => {
            this.is_checking_quest = false;
        })
    },

    fileInputChange(event) {
        Array.from(event.target.files).forEach(file => {
            const reader = new FileReader();
            reader.onload = (e) => this.onLoadImage(e.target.result);
            reader.readAsDataURL(file)
        });
    },

    dragAndDropFileUploaded(file) {
        const reader = new FileReader();
        reader.onload = (e) => this.onLoadImage(e.target.result);
        reader.readAsDataURL(file);
    },

    removeImage(image) {
        this.loaded_images = this.loaded_images.filter(li => li != image);
    },

    onLoadImage(image) {
        if(this.loaded_images.includes(image)) {
            toast('error', 'Данная картинка уже загружена');
            return;
        }

        if(this.loaded_images.length > 3) {
            toast('error', 'Допускается не более 3-х изображений');
            return;
        }

        this.loaded_images.push(image);
    }
});
