import "./bootstrap";

Alpine.data("deleteConfirmationModal", () => ({
    isOpen: false,
    itemToDelete: null,

    openModal(item) {
        this.itemToDelete = item;
        this.isOpen = true;
    },

    init() {
        window.addEventListener("open-delete-modal", (event) => {
            this.openModal(event.detail.item);
        });

        window.addEventListener("delete-item", (event) => {
            const item = event.detail.taskId;
            this.$refs["delete-form"].action = `/to-do/${item}`;
            this.$refs["delete-form"].submit();
            this.isOpen = false;
            this.itemToDelete = null;
        });
    },
}));

Alpine.start()
