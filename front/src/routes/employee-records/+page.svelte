<script>
    import EmployeeList from "../../components/EmployeeList.svelte";
    import Searchbar from "../../components/Searchbar.svelte";
    import Slider from "../../components/Slider.svelte";

    export let data

    let selectedUser = null
    const onClick = (user) => {
        selectedUser = user
        toggleSlider()
    }

    let showSlider = false
    const toggleSlider = () => {
        showSlider = !showSlider
    }
</script>

<div class="px-10">
    <Searchbar placeholderText="Szukaj pracownika..." />
    <EmployeeList {data} {onClick}/>
    <Slider {showSlider} {toggleSlider} user={selectedUser}/>
</div>