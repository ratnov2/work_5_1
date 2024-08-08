export default (site, player_site_quests) => ({
    site,
    player_site_quests,

    get newSiteQuests() {
        if(this.player_site_quests === null) return this.site.quests;
        return this.site.quests.filter(site_quest => !this.player_site_quests.map(player_site_quest => player_site_quest.site_quest.id).includes(site_quest.id))
    },

    get playerSiteQuests() {
        if(this.player_site_quests === null) return [];
        return this.player_site_quests;
    },

    get playerSiteQuestsInStart() {
        return this.playerSiteQuests.filter(player_site_quest => ['in_start'].includes(player_site_quest.status))
    },

    get playerSiteQuestsWaitWork() {
        return this.playerSiteQuests.filter(player_site_quest => ['wait_work'].includes(player_site_quest.status))
    },

    get playerSiteQuestsInWorking() {
        return this.playerSiteQuests.filter(player_site_quest => ['in_working'].includes(player_site_quest.status))
    },

    get playerSiteQuestsWaitDone() {
        return this.playerSiteQuests.filter(player_site_quest => ['wait_done'].includes(player_site_quest.status))
    },

    get playerSiteQuestsDone() {
        return this.playerSiteQuests.filter(player_site_quest => ['done'].includes(player_site_quest.status))
    },

    onUpdatedPlayerSiteQuest(player_site_quest) {
        const index = this.player_site_quests.findIndex((psq) => psq.id == player_site_quest.id);
        index == -1 ? this.player_site_quests.push(player_site_quest) : this.player_site_quests[index] = player_site_quest;
    }
});
