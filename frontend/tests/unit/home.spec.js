import { mount } from '@vue/test-utils'
import AnimeTable from '@/components/AnimeTable.vue'

describe('AnimeTable.vue', () => {
  it('renders a table', () => {
    const wrapper = mount(AnimeTable);
    expect(wrapper.contains('table').toBe(true));
  })
})
