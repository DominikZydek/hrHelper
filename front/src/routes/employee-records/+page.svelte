<script>
    import EmployeeList from "../../components/EmployeeList.svelte";
    import Searchbar from "../../components/Searchbar.svelte";
    import Slider from "../../components/Slider.svelte";

    export let data

    let allUsers = data.users
    let displayedUsers = allUsers

    let selectedUser = null
    const onClick = (user) => {
        selectedUser = user
        toggleSlider()
    }

    let showSlider = false
    const toggleSlider = () => {
        showSlider = !showSlider
    }

    const handleFilteredDataChange = (filteredData) => {
        displayedUsers = filteredData
    }
</script>

<div class="px-10">
    <Searchbar placeholderText="Szukaj pracownika..." searchData={allUsers} onFilteredDataChange={handleFilteredDataChange}/>
    <EmployeeList users={displayedUsers} {onClick}/>
    <Slider {showSlider} {toggleSlider} user={selectedUser} {allUsers} groups={data.groups}/>
</div>