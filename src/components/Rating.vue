<template>
  <div>
    <star-rating :rating="value" :round-start-rating="false" :star-size="20" :increment="1" :fixed-points="2" @rating-selected="updateValue"></star-rating>
  </div>
</template>

<script>
import StarRating from 'vue-star-rating'

export default {
  components: {
    'star-rating': StarRating
  },
  props: ['value'],
  methods: {
    updateValue: function (value) {
      this.$emit('input', value)
    }
  }
}
</script>