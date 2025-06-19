import { API_URL } from '$env/static/private';

export const load = async ({ locals, request, fetch }) => {
	const url = request.url.split('/');
	let path = '';

	if (url[url.length - 2] === 'employee-documents') {
		path = url[url.length - 1];
	} else {
		path = url[url.length - 2] + '/' + url[url.length - 1];
	}

	if (path === 'all') {
		path = null;
	}

	console.log(path);

	const query = `
    query ($organization: ID!, $collection: String) {
    me {
     organization {
      media_collections {
       id
       name
       display_name
      }
     }
    }
    files(organization: $organization, collection: $collection) {
     id
     name
     url
     thumbnail
     mime_type
     size
     created_at
     custom_properties
     collection {
      id
      name
      display_name
     }
     user {
      id
      first_name
      last_name
      email
      job_title
      groups {
       id
       name
       icon_name
      }
     }
    }
    users(organization: $organization) {
     id
     first_name
     last_name
    }
   }
  `;

	const { user } = locals;

	const variables = {
		organization: user.organization.id,
		collection: path
	};

	const res = await fetch(API_URL, {
		method: 'POST',
		headers: {
			'Content-Type': 'application/json'
		},
		credentials: 'include',
		body: JSON.stringify({ query, variables })
	}).then((res) => res.json());

	console.log(res.data.files);

	// filter out archive files when showing all
	const filteredFiles =
		path === null
			? res.data.files.filter((file) => file.collection.name !== 'archive')
			: res.data.files;

	// filter collections - hide archive only when viewing "all"
	const collections = getCollectionsWithHierarchy(res.data.me.organization.media_collections);
	const filteredCollections =
		path === null ? collections.filter((c) => c.name !== 'archive') : collections;

	return {
		collections: filteredCollections,
		files: filteredFiles,
		users: res.data.users
	};
};

const getCollectionsWithHierarchy = (collections, currentPath = null) => {
	let collectionsWithHierarchy = [];
	const parentMap = {};

	collections.forEach((c) => {
		if (!c.name.includes('/')) {
			const collectionObj = { ...c, children: [] };
			collectionsWithHierarchy.push(collectionObj);
			parentMap[c.name] = collectionObj;
		}
	});

	collections.forEach((c) => {
		if (c.name.includes('/')) {
			const parts = c.name.split('/');
			const parentName = parts[0];
			const childName = parts[1];

			const parent = parentMap[parentName];

			if (parent) {
				parent.children.push({
					...c,
					name: childName
				});
			} else {
				const newParent = {
					name: parentName,
					children: [
						{
							...c,
							name: childName
						}
					]
				};
				collectionsWithHierarchy.push(newParent);
				parentMap[parentName] = newParent;
			}
		}
	});

	// hide archive only when viewing "all"
	if (currentPath === null) {
		return collectionsWithHierarchy.filter((c) => c.name !== 'archive');
	}

	return collectionsWithHierarchy;
};
