<template>
  <div>
    <form @submit.prevent="submit">
      <div>
        <label>書籍名</label>
        <input type="text" v-model="book.item_name">
      </div>
      <div>
        <label>著者名</label>
        <input type="text" v-model="book.author">
      </div>
      <div>
        <label>評価</label>
        <rating v-model="book.rating"></rating>
      </div>
      <button type="submit">登録</button>
    </form>
  </div>
</template>

<script>
import Rating from './Rating.vue'

export default {
  components: {
    Rating
  },
  data() {
    return {
      book: {
        item_name: '',
        author: '',
        rating: 0
      }
    }
  },
  methods: {
    submit() {
      axios.post('/books', this.book)
        .then(() => {
          this.$router.push('/books')
        })
        .catch((error) => {
          console.log(error)
        })
    }
  }
}
</script>
