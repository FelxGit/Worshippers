<template>
  <button
  class="ui-button h-14"
  :class="classes"
  :disabled="disabled || loading"
  @click="onClick">
    <clip-loader class="loaderCenter grid content-center" :loading="withLoading" :color="loader.color.btPrimary" :size="loader.size"></clip-loader>

    <div class="ui-content" :class="iconPos">
        <div v-show="withIcon" class="ui-btn-icon">
            <i v-show="type == TYPE_CREATE" class="fa fa-plus" aria-hidden="true"></i>
            <i v-show="type == TYPE_EDIT" class='fas fa-edit'></i>
            <i v-show="type == TYPE_REMOVE" class='fa fa-remove'></i>
        </div>

        <div class="ui-btn-text">
            <slot></slot>
        </div>
    </div>
    </button>
</template>

<script>
import { getters, mutations, actions } from '../store'

export default {
    name: 'ui-button',
    props: {
        type: {
            type: String,
            default: 'create' // 'create', 'edit', 'remove'
        },
        size: {
            type: String,
            default: 'adjust' // 'adjust', 'full'
        },
        withIcon: {
            type: Boolean,
            default: false
        },
        iconPosition: {
            type: String,
            default: 'left' // 'left', 'right'
        },
        withLoading: {
            type: Boolean,
            default: false
        },
        disabled: {
            type: Boolean,
            default: false
        }
    },
    components: {
        //
    },
    data() {
        return {
        };
    },
    created() {
        // TYPE OF BUTTON
        this.TYPE_CREATE = "create";
        this.TYPE_EDIT = "edit";
        this.TYPE_REMOVE = "remove";

        this.ICON_LEFT = "left";
        this.ICON_RIGHT = "right";
    },
    computed: {
        ...getters,
        classes() {
            return [
                `ui-btn--type-${this.type}`,
                `ui-btn--size-${this.size}`,
                { 'is-loading': this.withLoading },
                { 'is-disabled': this.disabled || this.withLoading }
            ];
        },
        iconPos() {
            let iconPos = 'ui-btn--icon-left';

            if(this.ICON_RIGHT == this.iconPosition) {
                iconPos = [
                    `ui-btn--icon-right`
                ]
            }

            return iconPos;
        }
    },
    methods: {
        ...mutations, ...actions,
        onClick(e) {
            this.$emit('click', e);
        },

    }

}
</script>

<style scoped lang="scss">
@import '../../sass/imports';

.ui-button {
    width: 150px;
    height: $ui-input-button-size;
    border-radius: $ui-default-border-radius;
    position: relative;
}

.ui-btn--type-create {
    color: $primary-text-color;
    background-color: $brand-primary;
}

.ui-btn--type-edit {
    color: $primary-text-color;
    background-color: $brand-color-edit;
}

.ui-btn--type-remove {
    color: $primary-text-color;
    background-color: $brand-danger;
}

.ui-content {
    display: flex;
    justify-content: center;
    grid-gap: 10px;
}

// ================================================
// Icon position
// ================================================

.ui-btn--icon-left {
    flex-direction: row;
}

.ui-btn--icon-right {
    flex-direction: row-reverse;
}

// ================================================
// Button State
// ================================================

.is-loading, .is-disabled {
    opacity: 0.5
}

// ================================================
// Button Size
// ================================================
.ui-btn--size-adjust {
    width: 150px;
    height: 50px;
}

.ui-btn--size-full {
    width: 100%;
    padding: 10px;
    // font-size: 12px;
}

</style>